<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DonateController extends Controller
{
    private string $apiBase;
    private string $apiKey;
    private string $currency;
    private string $country;

    public function __construct()
    {
        $this->apiBase  = rtrim(config('broadpay.api_url'), '/');
        $this->apiKey   = config('broadpay.api_key');
        $this->currency = config('broadpay.currency', 'ZMW');
        $this->country  = config('broadpay.country', 'zm');
    }

    // ── GET /donate ──────────────────────────────────────────────────────────
    public function index()
    {
        return view('donate');
    }

    // ── POST /donate/initiate ─────────────────────────────────────────────────
    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'amount'         => ['required', 'numeric', 'min:10'],
            'fund'           => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'in:mobile_money,card'],
            'mobile_network' => ['required_if:payment_method,mobile_money', 'nullable', 'in:mtn,airtel,zamtel'],
            'first_name'     => ['required', 'string', 'max:80'],
            'last_name'      => ['required', 'string', 'max:80'],
            'email'          => ['required', 'email', 'max:120'],
            'phone'          => ['required_if:payment_method,mobile_money', 'nullable', 'string', 'max:20'],
            'card_number'    => ['required_if:payment_method,card', 'nullable', 'digits_between:13,19'],
            'card_expiry'    => ['required_if:payment_method,card', 'nullable', 'string', 'size:5'],
            'card_cvv'       => ['required_if:payment_method,card', 'nullable', 'digits_between:3,4'],
            'message'        => ['nullable', 'string', 'max:500'],
        ]);

        $reference = 'CHAZ-' . strtoupper(Str::random(12));
        $amount    = (float) $validated['amount'];

        // Create the donation record immediately (status = pending)
        $donation = Donation::create([
            'reference'      => $reference,
            'first_name'     => $validated['first_name'],
            'last_name'      => $validated['last_name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'] ?? null,
            'message'        => $validated['message'] ?? null,
            'amount'         => $amount,
            'currency'       => $this->currency,
            'fund'           => $validated['fund'],
            'payment_method' => $validated['payment_method'],
            'mobile_network' => $validated['mobile_network'] ?? null,
            'status'         => 'pending',
        ]);

        // ── Dev bypass: no credentials configured ─────────────────────────────
        if (empty($this->apiKey)) {
            $donation->update(['status' => 'successful', 'paid_at' => now()]);
            session([
                'donation_reference' => $reference,
                'donation_amount'    => number_format($amount, 2),
                'donation_fund'      => $validated['fund'],
            ]);
            Log::info('Lenco API key not configured — using dev bypass', compact('reference'));
            return redirect()->route('donate.success');
        }

        if ($validated['payment_method'] === 'mobile_money') {
            return $this->initiateMobileMoney($validated, $donation, $amount);
        }

        return $this->initiateCard($validated, $donation, $amount);
    }

    // ── Mobile Money ─────────────────────────────────────────────────────────
    private function initiateMobileMoney(array $data, Donation $donation, float $amount)
    {
        // Normalise phone to MSISDN format (no + prefix, e.g. 260971234567)
        $phone = preg_replace('/\D/', '', $data['phone']);
        if (str_starts_with($phone, '0')) {
            $phone = '260' . substr($phone, 1);
        }

        $payload = [
            'amount'      => $amount,
            'reference'   => $donation->reference,
            'phone'       => $phone,
            'operator'    => $data['mobile_network'],
            'country'     => $this->country,
            'currency'    => $this->currency,
            'bearer'      => 'merchant',
            'callbackUrl' => route('donate.callback'),
        ];

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                ])
                ->post($this->apiBase . '/collections/mobile-money', $payload);

            $body = $response->json();
            Log::info('Lenco mobile-money initiate', ['status' => $response->status(), 'body' => $body]);

            if ($response->successful() && ($body['status'] ?? false)) {
                $collectionId = $body['data']['id'] ?? null;
                $lencoRef     = $body['data']['lencoReference'] ?? $donation->reference;
                $pmStatus     = $body['data']['status'] ?? 'pending';

                $donation->update([
                    'lenco_reference' => $lencoRef,
                    'collection_id'   => $collectionId,
                    'phone'           => $phone,
                ]);

                session([
                    'donation_reference'    => $donation->reference,
                    'donation_lenco_ref'    => $lencoRef,
                    'donation_collection_id'=> $collectionId,
                    'donation_amount'       => number_format($amount, 2),
                    'donation_fund'         => $data['fund'],
                    'donation_phone'        => $phone,
                    'donation_operator'     => $data['mobile_network'],
                ]);

                if (in_array($pmStatus, ['pending', 'pay-offline'])) {
                    return redirect()->route('donate.pending');
                }

                if ($pmStatus === 'successful') {
                    $donation->update(['status' => 'successful', 'paid_at' => now()]);
                    return redirect()->route('donate.success');
                }
            }

            $errorMsg = $body['message'] ?? 'Mobile money payment could not be initiated.';
            $donation->update(['status' => 'failed', 'reason_for_failure' => $errorMsg]);
            Log::error('Lenco mobile-money failed', ['payload' => $payload, 'response' => $body]);

        } catch (\Exception $e) {
            $errorMsg = 'Payment gateway error. Please try again.';
            $donation->update(['status' => 'failed', 'reason_for_failure' => $e->getMessage()]);
            Log::error('Lenco mobile-money exception', ['message' => $e->getMessage()]);
        }

        return back()->withErrors(['payment' => $errorMsg ?? 'Payment failed.'])->withInput();
    }

    // ── Card ─────────────────────────────────────────────────────────────────
    private function initiateCard(array $data, Donation $donation, float $amount)
    {
        [$expMonth, $expYear] = explode('/', $data['card_expiry'] . '/');
        $expYear = strlen($expYear) === 2 ? '20' . $expYear : $expYear;

        $payload = [
            'amount'      => $amount,
            'reference'   => $donation->reference,
            'currency'    => $this->currency,
            'callbackUrl' => route('donate.callback'),
            'cardNumber'  => preg_replace('/\s/', '', $data['card_number']),
            'expiryMonth' => trim($expMonth),
            'expiryYear'  => trim($expYear),
            'cvv'         => $data['card_cvv'],
        ];

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                ])
                ->post($this->apiBase . '/collections/card', $payload);

            $body = $response->json();
            Log::info('Lenco card initiate', ['status' => $response->status(), 'body' => $body]);

            if ($response->successful() && ($body['status'] ?? false)) {
                $pmStatus     = $body['data']['status'] ?? '';
                $authUrl      = $body['data']['authorizationUrl'] ?? null;
                $collectionId = $body['data']['id'] ?? null;
                $lencoRef     = $body['data']['lencoReference'] ?? $donation->reference;

                $donation->update([
                    'lenco_reference' => $lencoRef,
                    'collection_id'   => $collectionId,
                ]);

                session([
                    'donation_reference'     => $donation->reference,
                    'donation_collection_id' => $collectionId,
                    'donation_amount'        => number_format($amount, 2),
                    'donation_fund'          => $data['fund'],
                ]);

                if ($authUrl) {
                    return redirect()->away($authUrl);
                }

                if ($pmStatus === 'successful') {
                    $donation->update(['status' => 'successful', 'paid_at' => now()]);
                    return redirect()->route('donate.success');
                }
            }

            $errorMsg = $body['message'] ?? 'Card payment could not be initiated.';
            $donation->update(['status' => 'failed', 'reason_for_failure' => $errorMsg]);
            Log::error('Lenco card failed', ['payload' => array_merge($payload, ['cardNumber' => '****']), 'response' => $body]);

        } catch (\Exception $e) {
            $errorMsg = 'Payment gateway error. Please try again.';
            $donation->update(['status' => 'failed', 'reason_for_failure' => $e->getMessage()]);
            Log::error('Lenco card exception', ['message' => $e->getMessage()]);
        }

        return back()->withErrors(['payment' => $errorMsg ?? 'Payment failed.'])->withInput();
    }

    // ── GET /donate/pending ───────────────────────────────────────────────────
    public function pending()
    {
        if (!session('donation_reference')) {
            return redirect()->route('donate');
        }

        return view('donate-pending', [
            'reference' => session('donation_reference'),
            'amount'    => session('donation_amount'),
            'fund'      => session('donation_fund'),
            'phone'     => session('donation_phone'),
            'operator'  => session('donation_operator'),
        ]);
    }

    // ── GET /donate/poll/{reference} ──────────────────────────────────────────
    public function poll(string $reference)
    {
        if (empty($this->apiKey)) {
            // Dev mode: mark successful
            Donation::where('reference', $reference)->whereNotIn('status', ['successful', 'failed'])->update([
                'status'  => 'successful',
                'paid_at' => now(),
            ]);
            return response()->json(['status' => 'successful']);
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept'        => 'application/json',
                ])
                ->get($this->apiBase . '/collections/status/' . $reference);

            $body = $response->json();

            if ($response->successful() && ($body['status'] ?? false)) {
                $status           = $body['data']['status'] ?? 'pending';
                $reasonForFailure = $body['data']['reasonForFailure'] ?? null;

                // Persist confirmed status changes
                if (in_array($status, ['successful', 'failed'])) {
                    $update = ['status' => $status];
                    if ($status === 'successful') {
                        $update['paid_at'] = now();
                    } elseif ($reasonForFailure) {
                        $update['reason_for_failure'] = $reasonForFailure;
                    }
                    Donation::where('reference', $reference)->update($update);
                }

                return response()->json([
                    'status'           => $status,
                    'reasonForFailure' => $reasonForFailure,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Lenco poll exception', ['message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'pending']);
    }

    // ── POST /donate/callback (Lenco webhook) ─────────────────────────────────
    public function callback(Request $request)
    {
        $rawBody = $request->getContent();
        $data    = json_decode($rawBody, true) ?? [];

        Log::info('Lenco webhook received', $data);

        // Verify HMAC SHA512 signature
        if (!empty($this->apiKey)) {
            $signature = $request->header('X-Lenco-Signature');
            if ($signature) {
                $webhookKey = hash('sha256', $this->apiKey);
                $computed   = hash_hmac('sha512', $rawBody, $webhookKey);
                if (!hash_equals($computed, $signature)) {
                    Log::warning('Lenco webhook signature mismatch');
                    return response()->json(['status' => 'invalid_signature'], 401);
                }
            }
        }

        $status    = $data['data']['status']    ?? '';
        $reference = $data['data']['reference'] ?? '';
        $lencoRef  = $data['data']['lencoReference'] ?? null;

        if ($reference && in_array($status, ['successful', 'failed'])) {
            $update = ['status' => $status];
            if ($lencoRef) {
                $update['lenco_reference'] = $lencoRef;
            }
            if ($status === 'successful') {
                $update['paid_at'] = now();
            } elseif ($status === 'failed') {
                $update['reason_for_failure'] = $data['data']['reasonForFailure'] ?? null;
            }
            Donation::where('reference', $reference)->update($update);
            Log::info("Donation [{$reference}] updated to status={$status} via webhook");
        }

        return response()->json(['status' => 'received']);
    }

    // ── GET /donate/success ───────────────────────────────────────────────────
    public function success(Request $request)
    {
        $reference = session('donation_reference') ?? $request->query('reference', '');
        $amount    = session('donation_amount')    ?? $request->query('amount', '');
        $fund      = session('donation_fund')      ?? $request->query('fund', 'General Fund');

        session()->forget([
            'donation_reference', 'donation_lenco_ref', 'donation_collection_id',
            'donation_amount', 'donation_fund', 'donation_phone', 'donation_operator',
        ]);

        return view('donate-success', compact('reference', 'amount', 'fund'));
    }

    // ── GET /donate/cancel ────────────────────────────────────────────────────
    public function cancel()
    {
        // Mark any session donation as cancelled
        if ($ref = session('donation_reference')) {
            Donation::where('reference', $ref)->where('status', 'pending')
                ->update(['status' => 'cancelled']);
        }
        return view('donate-cancel');
    }
}
