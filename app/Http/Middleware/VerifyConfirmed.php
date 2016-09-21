<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Lang;
use Session;

class VerifyConfirmed
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
        $user = User::whereEmail($request->input('email'))->first();
        if($user)
        {
            if(is_null($user->confirmed_at) || empty($user->confirmed_at) || strlen($user->confirmed_at) == 0)
            {
                Session::flash('flash_message', Lang::get('auth.activate'));
                return back()->withInput($request->only('email'));
            }
        }
        return $next($request);
    }
}
