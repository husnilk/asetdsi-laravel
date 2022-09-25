<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class PjSession
{

    public function handle($request, Closure $next)
    {
       
        if (Auth::guard('pj')->check()) {
            // user value cannot be found in session
            return redirect('/pj-aset');
        }

        return $next($request);
    }

}