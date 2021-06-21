<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
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
        if (Auth::user()->role == 'admin')
        {
            return $next($request);
            // si l'user est admin, on permet son accès aux pages admin
        }
        else
        {
            Auth::logout();
            Session::flush();
            return redirect()->route('login');
            // sinon on le déco et on le renvoie à login
        }
    }
}

// on a créé ce middleware mais il faut maintenant le renseigner dans le kernel
