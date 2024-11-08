<?php

namespace App\Http\Middleware;

use App\Models\Menurole;
use App\Models\Menus;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
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
        $uri = $request->route()->uri;
        $menu = Menus::where('href', '/' . $uri)->first();
        $userRoles = explode(",", Auth::user()->menuroles);
        if($menu){
            $permission = Menurole::whereIn('role_name', $userRoles)->where('menus_id', $menu->id)->get();
            if (count($permission) === 0) {
                return abort(401);
            }
        }
        return $next($request);
    }
}
