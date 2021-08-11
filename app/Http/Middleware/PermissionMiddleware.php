<?php

namespace App\Http\Middleware;

use App\Models\User;

use Closure;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
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
        if(auth()->user() && auth()->user()->role_id) 
        {
            auth()->user()->load('roleWithPermissions');

            $user = auth()->user();

            $user->roleWithPermissions->permissions->map(function($permission) {
                Gate::define($permission->code, function() { return true; });
            });
        }
        
        return $next($request);
    }
}
