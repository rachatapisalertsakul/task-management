<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class chklogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        session_start();
        // dd($_SESSION);
        if (isset($_SESSION['username'])) {
            // dd('hi');
            return ($next($request));
        } else {
            // dd('this');
            return redirect()->route('login');
        }
    }
}
