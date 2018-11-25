<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (Auth::check() && $request->user()->hasRole('admin')){
            return $next($request);
        }
        if(!Auth::check() || !$request->user()->hasRole($role)) {
            abort(404);
        }
        if(!Auth::check() || $permission != null && !Auth::user()->can($permission)) {
            abort(404);
        }
        return $next($request);
    }
}
