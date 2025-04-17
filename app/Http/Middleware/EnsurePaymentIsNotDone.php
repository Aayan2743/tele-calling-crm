<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EnsurePaymentIsNotDone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        // Ensure the payment record exists and is fresh
        $payment = $user->fresh()->payment;
    
        

        if ($payment && !Carbon::parse($payment->expire_date)->isPast()) {
            // Redirect user to the dashboard (or any other page) if payment is valid
            return redirect()->route('dashboard');
        }

       
    



        return $next($request);




     
    }
}
