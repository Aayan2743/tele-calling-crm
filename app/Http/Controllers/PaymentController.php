<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Dipesh79\LaravelPhonePe\LaravelPhonePe;
use Illuminate\Support\Facades\Redirect;
use RequestParseBodyException;
class PaymentController extends Controller
{
    //

    public function pay(Request $request)
    {
        //   dd($request->all());
      
        $phonePe = new LaravelPhonePe();


        $amount = $request->input('amount'); // already in paise
        $phoneNumber = '9999999999'; // replace with real user number if available
        $callbackUrl = url('/payment/callback'); // generates full callback URL
        $merchantTransactionId = 'TXN' . time() . rand(1000, 9999);
    
        try {
            $url = $phonePe->makePayment($amount, $phoneNumber, $callbackUrl, $merchantTransactionId);
    
            return response()->json([
                'success' => true,
                'paymentUrl' => $url
            ]);


            // return response()->json([
            //         'success' => true,
            //         'paymentUrl' => $responseData['paymentUrl'], // This is the URL to redirect user to PhonePe payment page
            //     ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate PhonePe payment',
                'error' => $e->getMessage()
            ], 500);
        }


    }

    public function callback(Request $request)
        {
            $phonepe = new LaravelPhonePe();
            \Log::info('PhonePe Callback Received:', $request->all());

                try {
                    // This should handle signature validation and status check
                    $response = $phonepe->getTransactionStatus($request->all());

                    if ($response === true) {
                        // ✅ Payment was successful
                        // You can mark order/subscription as paid here

                        return response()->json([
                            'success' => true,
                            'message' => 'Payment successful!'
                        ]);
                    } else {
                        // ❌ Payment failed
                        return response()->json([
                            'success' => false,
                            'message' => 'Payment failed or was canceled'
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error('PhonePe Callback Error:', ['error' => $e->getMessage()]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong while processing callback',
                        'error' => $e->getMessage()
                    ], 500);
                }
          
          
          
          
          
          
          
          
          
            // $response = $phonepe->getTransactionStatus($request->all());
            // if($response == true){
            //     // Payment Success
            // }
            // else
            // {
            //     // Payment Failed           
            // }
     }


  
}
