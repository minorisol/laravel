<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminAuthenticate
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
        if(Auth::check())
        {
            if(Auth::user()->role == 'admin')
            {
                // do nothing
            }
            else
            {
                return redirect('/');
            }
        }
        else
        {
            return redirect('/');
        }
        return $next($request);
    }
}
