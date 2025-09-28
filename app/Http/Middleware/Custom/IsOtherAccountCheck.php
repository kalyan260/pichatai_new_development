<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsOtherAccountCheck
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
        if (Auth::user()->id == $request->route()->parameters['id']) :
            return $next($request);
        else :
            return redirect()->route('unauthorized')->with('error', 'You Access An Unauthorized Page');
        endif;
        return $next($request);
    }
}
