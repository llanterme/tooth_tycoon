<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Session\Middleware\StartSession;


class AdminCheck
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
        $request->session()->has('_admin_session');
        $cheack=$request->session()->has('_admin_session');

        // dd($cheack);/admin
        $email="";
        if(!empty($cheack))
        {
            $email=$request->session()->all()['_admin_session']['email'];
        }
        else
        {
            // return "false";
            return redirect('login');
        }
        if( $email=="" )
        {
            return redirect('login');
        }

        return $next($request);
    }
}
