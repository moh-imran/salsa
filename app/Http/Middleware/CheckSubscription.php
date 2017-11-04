<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Session;
class CheckSubscription
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
//        if admin then proceed next
        $user_roles =  Auth::user()->roles()->get();
        $super_admin = $user_roles->where('title', 'super admin');
        $admin = $user_roles->where('title', 'admin');
        if(!$admin->isEmpty() || !$super_admin->isEmpty()) {
            return $next($request);
        }
//        check client subscription
        $subscription = Auth::user()->user_subscription()->get();
        if($subscription->isEmpty()){
            Session::flash('flash_warning', 'You needs to subscribe for view this page');
            return redirect('subscribe');
        }
        date_default_timezone_set("Europe/Stockholm");
        $date = date('Y-m-d H:i:s');
        $subscription_end = $subscription[count($subscription)-1]->subscription_ends_at;
        if(strtotime($subscription_end) <= strtotime($date)){
            Session::flash('flash_warning', 'Your subscription is expire please renew your plane');
            return redirect('subscribe');
        }
        return $next($request);
    }
}
