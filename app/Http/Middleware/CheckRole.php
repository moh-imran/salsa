<?php

namespace App\Http\Middleware;

use App\Permission;
use App\Role;
use Closure;
use Auth, Log;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $url = $request->getRequestUri();

        $explodedURL = explode("?", $url);

        $requestURI = $explodedURL[0];

        $parameters =  $request->route()->parameters();
        if(!empty($parameters)){
            foreach ($parameters as $parameter){
                $requestURI = str_replace("/".$parameter, "", $requestURI);
            }
        }

//      check if it is crud based url then just get main part of url
        $pos = strrpos($requestURI, '/');
        $last = $pos === false ? $requestURI : substr($requestURI, $pos + 1);
        if($last == 'create' || $last == 'edit'){
            $requestURI = substr($requestURI, 0, $pos);
        }

        $final_url = str_replace('/', '_', $requestURI);

        $requestPermission = strtolower("manage". $final_url);

        $role_id = Auth::user()->roles->first()->pivot->role_id;

        $permissions = Role::find($role_id)->permissions->pluck('title')->toArray();

        $user_roles =  Auth::user()->roles()->get();

        $super_admin = $user_roles->where('title', 'super admin');

        $admin = $user_roles->where('title', 'admin');

        if (!Auth::check()) {
            return redirect('admin/login');
        } elseif(!$admin->isEmpty() || !$super_admin->isEmpty()) {
            if($requestURI == 'admin'){
                return redirect('admin/dashboard');
            }elseif (in_array($requestPermission, $permissions)) {
                return $next($request);
            } else {
                $label = Permission::where('title', $requestPermission)->first()->label;
                Session::flash('flash_warning', 'You are not authorized, You don\'t have ' . strtoupper($label) . ' permission in your Role!');
                return redirect()->back();
            }
        }else{
            return redirect('/home');
        }

    }

}
