<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class EnsurePaymentIsDone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // $user = Auth::user();

        // $payment = $user->payment;
        


        // if (
        //     !$payment ||  Carbon::parse($payment->expire_date)->isPast()
        // ) {
        
        //     return redirect()->route('payment.page');
        // }



        // return $next($request);

        $user = Auth::user();

        // Ensure the payment record exists and is fresh
        $payment = $user->fresh()->payment;
    
        // Check if we are already on the payment page
        if ($request->route()->getName() === 'payment.page') {
            return $next($request); // Allow the user to stay on the payment page
        }
    
        // If no payment record exists or if the payment is expired, redirect to payment page
        if (!$payment || Carbon::parse($payment->expire_date)->isPast()) {
            return redirect()->route('payment.page')->with('error', 'Your subscription has expired. Please renew.');
        }

        // if ($payment && !Carbon::parse($payment->expire_date)->isPast()) {
        //     // Redirect user to the dashboard (or any other page) if payment is valid
        //     return redirect()->route('dashboard');
        // }

       
    



        return $next($request);
    }
}
