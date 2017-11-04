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
        if (Auth::guard($guard)->check()) {
            $user_roles =  Auth::user()->roles()->get();
            $super_admin = $user_roles->where('title', 'super admin');
            $admin = $user_roles->where('title', 'admin');
//          check if have not admin or super admin roles.
            if(!$admin->isEmpty() || !$super_admin->isEmpty()) {
                return redirect('admin/dashboard');
            }
            return redirect('/');
        }

        return $next($request);
    }
}
