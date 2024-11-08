<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\App;

class SetSessionMiddleware
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
        if(!empty($request->input('current_locale'))){
            Session::put('current_locale',$request->input('current_locale'));
            App::setLocale($request->input('current_locale'));
        }
        return $next($request);
    }
}
