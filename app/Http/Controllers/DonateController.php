<?php

namespace App\Http\Controllers;

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

        // ── Dev bypass: no credentials configured ─────────────────────────────
        if (empty($this->apiKey)) {
            session([
                'donation_reference' => $reference,
                'donation_amount'    => number_format($amount, 2),
                'donation_fund'      => $validated['fund'],
            ]);
            Log::info('Lenco API key not configured — using dev bypass', compact('reference'));
            return redirect()->route('donate.success');
        }

        if ($validated['payment_method'] === 'mobile_money') {
            return $this->initiateMobileMoney($validated, $reference, $amount);
        }

        return $this->initiateCard($validated, $reference, $amount);
    }

    // ── Mobile Money ─────────────────────────────────────────────────────────
    private function initiateMobileMoney(array $data, string $reference, float $amount)
    {
        // Normalise phone to MSISDN format (no + prefix, e.g. 260971234567)
        $phone = preg_replace('/\D/', '', $data['phone']);
        if (str_starts_with($phone, '0')) {
            $phone = '260' . substr($phone, 1);
        }

        $payload = [
            'amount'      => $amount,
            'reference'   => $reference,
            'phone'       => $phone,
            'operator'    => $data['mobile_network'],   // mtn | airtel | zamtel
            'country'     => $this->country,            // zm
            'currency'    => $this->currency,           // ZMW
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
                $lencoRef     = $body['data']['lencoReference'] ?? $reference;
                $pmStatus     = $body['data']['status'] ?? 'pending';

                session([
                    'donation_reference'    => $reference,
                    'donation_lenco_ref'    => $lencoRef,
                    'donation_collection_id'=> $collectionId,
                    'donation_amount'       => number_format($amount, 2),
                    'donation_fund'         => $data['fund'],
                    'donation_phone'        => $phone,
                    'donation_operator'     => $data['mobile_network'],
                ]);

                // pay-offline / pending = customer must approve USSD prompt
                if (in_array($pmStatus, ['pending', 'pay-offline'])) {
                    return redirect()->route('donate.pending');
                }

                // Already successful (rare, but handle it)
                if ($pmStatus === 'successful') {
                    return redirect()->route('donate.success');
                }
            }

            $errorMsg = $body['message'] ?? 'Mobile money payment could not be initiated.';
            Log::error('Lenco mobile-money failed', ['payload' => $payload, 'response' => $body]);

        } catch (\Exception $e) {
            $errorMsg = 'Payment gateway error. Please try again.';
            Log::error('Lenco mobile-money exception', ['message' => $e->getMessage()]);
        }

        return back()->withErrors(['payment' => $errorMsg ?? 'Payment failed.'])->withInput();
    }

    // ── Card ─────────────────────────────────────────────────────────────────
    private function initiateCard(array $data, string $reference, float $amount)
    {
        [$expMonth, $expYear] = explode('/', $data['card_expiry'] . '/');
        $expYear = strlen($expYear) === 2 ? '20' . $expYear : $expYear;

        $payload = [
            'amount'      => $amount,
            'reference'   => $reference,
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
                $pmStatus      = $body['data']['status'] ?? '';
                $authUrl       = $body['data']['authorizationUrl'] ?? null;
                $collectionId  = $body['data']['id'] ?? null;

                session([
                    'donation_reference'     => $reference,
                    'donation_collection_id' => $collectionId,
                    'donation_amount'        => number_format($amount, 2),
                    'donation_fund'          => $data['fund'],
                ]);

                // 3DS or further auth required — redirect to Lenco's auth page
                if ($authUrl) {
                    return redirect()->away($authUrl);
                }

                if ($pmStatus === 'successful') {
                    return redirect()->route('donate.success');
                }
            }

            $errorMsg = $body['message'] ?? 'Card payment could not be initiated.';
            Log::error('Lenco card failed', ['payload' => array_merge($payload, ['cardNumber' => '****']), 'response' => $body]);

        } catch (\Exception $e) {
            $errorMsg = 'Payment gateway error. Please try again.';
            Log::error('Lenco card exception', ['message' => $e->getMessage()]);
        }

        return back()->withErrors(['payment' => $errorMsg ?? 'Payment failed.'])->withInput();
    }

    // ── GET /donate/pending (mobile money waiting page) ───────────────────────
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

    // ── GET /donate/poll/{reference}  (AJAX status check) ────────────────────
    public function poll(string $reference)
    {
        if (empty($this->apiKey)) {
            return response()->json(['status' => 'successful']); // dev mode
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
                $status = $body['data']['status'] ?? 'pending';
                return response()->json([
                    'status'           => $status,
                    'reasonForFailure' => $body['data']['reasonForFailure'] ?? null,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Lenco poll exception', ['message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'pending']);
    }

    // ── POST /donate/callback  (Lenco webhook) ────────────────────────────────
    public function callback(Request $request)
    {
        $rawBody  = $request->getContent();
        $data     = json_decode($rawBody, true) ?? [];

        Log::info('Lenco webhook received', $data);

        // Verify HMAC SHA512 signature
        // Lenco's webhook key = sha256(api_key), then HMAC-SHA512 the raw body
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

        $event     = $data['event']             ?? '';
        $status    = $data['data']['status']    ?? '';
        $reference = $data['data']['reference'] ?? '';

        Log::info("Lenco webhook [{$event}] ref={$reference} status={$status}");

        // Respond 200 immediately — Lenco retries if no 2xx within timeout
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
        return view('donate-cancel');
    }
}
