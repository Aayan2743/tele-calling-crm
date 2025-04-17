<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PhonePeController extends Controller
{
    //
    public function submitPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'mobile' => 'required|digits:10',
        ]);

        $merchantId = env('PHONEPE_MERCHANT_ID');
        $saltKey = env('PHONEPE_SALT_KEY');
        $saltIndex = env('PHONEPE_SALT_INDEX');
        $apiUrl = env('PHONEPE_API_URL');
        $amount = $request->amount * 100; // Convert to paise
        $merchantTransactionId = 'TXN' . time();
        $callbackUrl = env('PHONEPE_CALLBACK_URL');
        $redirectUrl = env('PHONEPE_REDIRECT_URL');

        $payload = [
            'merchantId' => $merchantId,
            'merchantTransactionId' => $merchantTransactionId,
            'merchantUserId' => 'MUID' . time(),
            'amount' => $amount,
            'redirectUrl' => $redirectUrl,
            'callbackUrl' => $callbackUrl,
            'mobileNumber' => $request->mobile,
            'paymentInstrument' => [
                'type' => 'PAY_PAGE'
            ]
        ];

        $jsonPayload = base64_encode(json_encode($payload));
        $checksum = hash('sha256', $jsonPayload . '/pg/v1/pay' . $saltKey) . '###' . $saltIndex;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-VERIFY' => $checksum,
            ])->post("{$apiUrl}/pg/v1/pay", [
                'request' => $jsonPayload
            ]);

            $result = $response->json();
            dd($result);
            if ($response->successful() && isset($result['success']) && $result['success'] && isset($result['data']['instrumentResponse']['redirectInfo']['url'])) {
                return redirect($result['data']['instrumentResponse']['redirectInfo']['url']);
            }

            Log::error('PhonePe Payment Initiation Failed', ['response' => $result]);
            return back()->withErrors(['error' => 'Payment initiation failed']);
        } catch (\Exception $e) {
            Log::error('PhonePe Payment Error', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Payment initiation error']);
        }
    }

    public function response(Request $request)
    {
        $merchantId = env('PHONEPE_MERCHANT_ID');
        $saltKey = env('PHONEPE_SALT_KEY');
        $saltIndex = env('PHONEPE_SALT_INDEX');
        $apiUrl = env('PHONEPE_API_URL');
        $transactionId = $request->input('transactionId');

        if (!$transactionId) {
            Log::error('Invalid Transaction ID');
            return view('payment-failed', ['message' => 'Invalid transaction ID']);
        }

        $checksum = hash('sha256', "/pg/v1/status/{$merchantId}/{$transactionId}" . $saltKey) . '###' . $saltIndex;

        try {
            $statusResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-VERIFY' => $checksum,
                'X-MERCHANT-ID' => $merchantId,
            ])->get("{$apiUrl}/pg/v1/status/{$merchantId}/{$transactionId}");

            $status = $statusResponse->json();

            if ($statusResponse->successful() && isset($status['success']) && $status['success'] && $status['code'] === 'PAYMENT_SUCCESS') {
                // Update your database with transaction details
                Log::info('Payment Successful', $status);
                return view('payment-success', ['data' => $status['data']]);
            }

            Log::error('Payment Failed', ['status' => $status]);
            return view('payment-failed', ['message' => $status['message'] ?? 'Payment failed']);
        } catch (\Exception $e) {
            Log::error('PhonePe Status Check Error', ['error' => $e->getMessage()]);
            return view('payment-failed', ['message' => 'Status check failed']);
        }
    }
}
