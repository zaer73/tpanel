<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RegistrationPaymentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            // dd(!$request->is("financial/checkout/moving-to-gateway"));
            if(
                Auth::user()->registration_payment 
                && Auth::user()->registration_payment->status == 0
            ){
                if(
                    !$request->is("users/registration-payment") 
                    && !$request->is("financial/*")
                )
                {
                    return redirect()->route('users.registrationPayment');
                } 
            }
        }
        return $next($request);
    }
}
