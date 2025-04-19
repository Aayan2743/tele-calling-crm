<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use App\Models\plan;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
class RozarpayController extends Controller
{
    //
    public function createOrder(Request $request)
    {
      
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        // Amount to be captured (in paise; 1 INR = 100 paise)
        $amount = $request->amount * 100;  // In paise, e.g., 5000 paise = 50 INR
        $planId = $request->planId ;
        $paymentMethod = $request->paymentMethod ; 

        // Create an order
        $orderData = [
            'receipt' => 'order_rcptid_' . time(),
            'amount' => $amount,
            'currency' => 'INR',
            'payment_capture' => 1,
            'notes'           => [
                'plan_id'   => $planId,
                'paymentMethod'   => $paymentMethod,
                
            ]
        ];
       
        try {
            $razorpayOrder = $api->order->create($orderData);
          
          

            return response()->json([
                'order_id' => $razorpayOrder['id'],
                'amount' => $request->amount,
                'key' => env('RAZORPAY_KEY_ID')
            ]);
    

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create Razorpay order', 'message' => $e->getMessage()], 500);
            // return back()->with('error', 'Error occurred while creating order');
        }
    }

    // Handle the payment response
    // public function handlePaymentCallback(Request $request)
    // {
    
    //     $paymentId = $request->input('payment_id');
    //     $orderId = $request->input('order_id');
    //     $signature = $request->input('signature');
        
    //     if (empty($paymentId) || empty($orderId) || empty($signature)) {
    //         return response()->json(['error' => 'Failed to create Razorpay order'], 500);
    //         // return redirect()->route('payment.failure')->with('error', 'Invalid payment data');
    //     }
    
    //     $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    //     $order = $api->order->fetch($orderId);
    
    //     // Generate the signature hash to verify payment authenticity
    //     $generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, env('RAZORPAY_KEY_SECRET'));
      
    //     if ($signature === $generatedSignature) {
    //         // Payment was successful

    //         $paymentdetails=Payment::create([
    //             'user_id'=>Auth::id,
    //            'plan'=>'test',
    //            'expire_date'=>'test',

                
    //         ]);
    //         // $orderRecord = Order::where('order_id', $orderId)->first();
    //         // $orderRecord->status = 'completed';
    //         // $orderRecord->payment_id = $paymentId;
    //         // $orderRecord->save();
            
    //         // return redirect()->route('payment.success')->with('message', 'Payment successful!');
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'create Razorpay order'
    //         ], 200);

    //         return redirect()->route('payment.page')->with('message', 'Payment successful!');
    //     } else {
    //         // Signature mismatch
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Failed to create Razorpay order'
    //         ], 200);
    //         return redirect()->route('payment.page')->with('error', 'Payment signature mismatch!');
    //     }

    // }


    public function handlePaymentCallback(Request $request)
{
    $paymentId = $request->input('payment_id');
    $orderId = $request->input('order_id');
    $signature = $request->input('signature');

    if (empty($paymentId) || empty($orderId) || empty($signature)) {
        return response()->json(['error' => 'Missing payment data'], 500);
    }

    $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

    // Verify order signature
    $generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, env('RAZORPAY_KEY_SECRET'));

    if ($signature === $generatedSignature) {
        // ✅ Signature matched — Now fetch payment details
        $payment = $api->payment->fetch($paymentId);

        // Get custom fields from 'notes'
        $planId = $payment->notes['plan_id'] ?? null;
        $paymentMethod = $payment->notes['paymentMethod'] ?? null;
        

        $get_plan_details=plan::where('id', $planId)->first();

       
        $expire_date = now();
        $planName = "";
        if ($get_plan_details && $get_plan_details->days) {
            $expire_date = now()->addDays($get_plan_details->days);
            $planName = $get_plan_details->description;
        }


        // Save payment to database
        $paymentdetails = Payment::create([
            'user_id'        => Auth::id(),
            'razorpay_id'    => $paymentId,
            'order_id'       => $orderId,
            'plan_id'        => $planId,
            'payment_method' => $paymentMethod,
            'plan' => $planName,
            'amount'         => $payment->amount / 100, // optional
            'expire_date'    => $expire_date, // for example, 1-month plan
        ]);

        if($paymentdetails){
            // dd($paymentdetails);
            $companyId = Auth::user()->company_id;
            
          
            if ($companyId) {

                dd(" not null case");
                $payment = $payment::where('user_id',Auth::id())->update([
                    'company_id'=> $companyId,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Payment successful and saved.',
                ]);
               
            } else {
                
                $uniqueCompanyID = strtolower(substr(md5(time() . uniqid(rand(), true)), 0, 12));
                $payment = payment::where('user_id',Auth::id())->update([
                    'company_id'=> $uniqueCompanyID,
                ]);
               
                $user = user::find( Auth::id());
               
              
                if ($user) {
                    $user->company_id = $uniqueCompanyID;
                    $user->save();
                    return response()->json(['status'=>'true','message' => 'complete'], 200);
                } else {
                    // Handle case where user not found
                    return response()->json(['message' => 'User not found'], 404);
                }
                // company_id is null
            }

           
        }

       
    } 
    else {
        // ❌ Signature mismatch
        return response()->json([
            'status' => false,
            'message' => 'Payment verification failed!',
        ]);
    }


}
}
