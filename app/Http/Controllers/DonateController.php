<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DonateController extends Controller
{
    // Broadpay / Lenco API base URL (sandbox vs live toggled via env)
    private string $apiBase;
    private string $merchantId;
    private string $apiKey;

    public function __construct()
    {
        $this->apiBase    = rtrim(config('broadpay.api_url'), '/');
        $this->merchantId = config('broadpay.merchant_id');
        $this->apiKey     = config('broadpay.api_key');
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
            'amount'          => ['required', 'numeric', 'min:10'],
            'fund'            => ['required', 'string', 'max:100'],
            'payment_method'  => ['required', 'in:mobile_money,card'],
            'mobile_network'  => ['required_if:payment_method,mobile_money', 'nullable', 'in:mtn,airtel,zamtel'],
            'first_name'      => ['required', 'string', 'max:80'],
            'last_name'       => ['required', 'string', 'max:80'],
            'email'           => ['required', 'email', 'max:120'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'message'         => ['nullable', 'string', 'max:500'],
        ]);

        $reference = 'CHAZ-DON-' . strtoupper(Str::random(10));
        $amount    = number_format((float) $validated['amount'], 2, '.', '');

        // ── Dev / sandbox bypass ──────────────────────────────────────────────
        // When Broadpay credentials are not yet configured, skip the API call
        // and land directly on the success page so the full flow can be tested.
        if (empty($this->merchantId) || empty($this->apiKey)) {
            session([
                'donation_reference' => $reference,
                'donation_amount'    => $amount,
                'donation_fund'      => $validated['fund'],
            ]);
            Log::info('Broadpay credentials not configured — skipping live API call', compact('reference', 'amount'));
            return redirect()->route('donate.success');
        }

        // Build the payment initiation payload for Broadpay / Lenco
        $payload = [
            'merchant_id'    => $this->merchantId,
            'reference'      => $reference,
            'amount'         => $amount,
            'currency'       => 'ZMW',
            'description'    => 'CHAZ Donation — ' . $validated['fund'],
            'customer'       => [
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'] ?? '',
            ],
            'return_url'     => route('donate.success'),
            'cancel_url'     => route('donate.cancel'),
            'callback_url'   => route('donate.callback'),
            'payment_method' => $validated['payment_method'],
            'mobile_network' => $validated['mobile_network'] ?? null,
            'metadata'       => [
                'fund'           => $validated['fund'],
                'message'        => $validated['message'] ?? '',
                'donor'          => $validated['first_name'] . ' ' . $validated['last_name'],
                'payment_method' => $validated['payment_method'],
                'mobile_network' => $validated['mobile_network'] ?? null,
            ],
        ];

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                ])
                ->post($this->apiBase . '/checkout/initiate', $payload);

            if ($response->successful()) {
                $data = $response->json();

                // Broadpay returns a hosted checkout URL to redirect the donor to
                $checkoutUrl = $data['checkout_url'] ?? $data['payment_url'] ?? $data['redirect_url'] ?? null;

                if ($checkoutUrl) {
                    session([
                        'donation_reference' => $reference,
                        'donation_amount'    => $amount,
                        'donation_fund'      => $validated['fund'],
                    ]);
                    return redirect()->away($checkoutUrl);
                }
            }

            Log::error('Broadpay initiation failed', [
                'status'  => $response->status(),
                'body'    => $response->body(),
                'payload' => $payload,
            ]);

        } catch (\Exception $e) {
            Log::error('Broadpay exception', ['message' => $e->getMessage()]);
        }

        return back()
            ->withErrors(['payment' => 'Payment gateway is temporarily unavailable. Please try again shortly or contact us at info@chaz.org.zm.'])
            ->withInput();
    }

    // ── POST /donate/callback  (Broadpay webhook) ─────────────────────────────
    public function callback(Request $request)
    {
        $data = $request->all();
        Log::info('Broadpay donation callback', $data);

        // Verify the webhook signature if Broadpay provides one
        $signature = $request->header('X-Broadpay-Signature') ?? $request->header('X-Lenco-Signature');
        if ($signature && config('broadpay.webhook_secret')) {
            $computed = hash_hmac('sha256', $request->getContent(), config('broadpay.webhook_secret'));
            if (!hash_equals($computed, $signature)) {
                Log::warning('Broadpay webhook signature mismatch');
                return response()->json(['status' => 'invalid_signature'], 401);
            }
        }

        // Log/store successful donations as needed
        $status    = $data['status'] ?? $data['transaction_status'] ?? 'unknown';
        $reference = $data['reference'] ?? $data['merchant_reference'] ?? '';

        Log::info("Donation [{$reference}] status: {$status}");

        return response()->json(['status' => 'received']);
    }

    // ── GET /donate/success ───────────────────────────────────────────────────
    public function success(Request $request)
    {
        $reference = session('donation_reference') ?? $request->query('reference', '');
        $amount    = session('donation_amount')    ?? $request->query('amount', '');
        $fund      = session('donation_fund')      ?? $request->query('fund', 'General Fund');

        session()->forget(['donation_reference', 'donation_amount', 'donation_fund']);

        return view('donate-success', compact('reference', 'amount', 'fund'));
    }

    // ── GET /donate/cancel ────────────────────────────────────────────────────
    public function cancel()
    {
        return view('donate-cancel');
    }
}
