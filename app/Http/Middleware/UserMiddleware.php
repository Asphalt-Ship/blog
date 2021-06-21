<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->role == 'user')
        {
            return $next($request);
        }
        else
        {
            Auth::logout();
            Session::flush();
            return redirect()->route('login');
        }
    }
}

// avec ce middleware, on s'assure que les admins n'ont pas accès à la partie des users
