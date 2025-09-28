<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsPhoneVerify
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
        if (Auth::user()->mobile != null) :
            return $next($request);
        else :
            return redirect()->route('verify-phone-number')->with('error', 'Please Verify Your Mobile Number.');
        endif;
        return $next($request);
    }
}
