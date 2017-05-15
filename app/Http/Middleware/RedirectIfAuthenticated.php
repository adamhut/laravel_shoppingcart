<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //Session::put('oldUrl',request()->url);

        if (Auth::guard($guard)->check()) {
           // if(Session::has('oldUrl'))
            //{
            //    return redirect()->to(Session::get('oldUrl'));
            //}
            return redirect('/profile');
        }

        return $next($request);
    }
}
