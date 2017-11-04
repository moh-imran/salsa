<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function adminLoginForm()
    {
        return view('admin.login');
    }
    
    public function showLoginForm()
    {
        return view('user.login');
    }
    

    public function adminLogin(Request $request){
        $this->validate($request, ['email' => 'required', 'password' => 'required'],
        [            
            'password.required' => 'Var vänlig fyll i det här fältet.',
            'email.required' => 'Ange en giltig e-postadress.'                        
        ]);
        if ( Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect('test');
        }else{
            return $this->sendFailedLoginResponse($request);
        }
    }

    public function redirectPath()
    {
        
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }
        $user_roles =  Auth::user()->roles()->get();
        $super_admin = $user_roles->where('title', 'super admin');
        $admin = $user_roles->where('title', 'admin');

//      check if have not admin or super admin roles.
        if($admin->isEmpty() && $super_admin->isEmpty()) {
            $subscription = Auth::user()->user_subscription()->get();
            if($subscription->isEmpty()){
                Session::flash('flash_message', 'Welcome <strong>' . Auth::user()->name . ' </strong> to Salsa ! ');
                return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
            }else{
                date_default_timezone_set("Europe/Stockholm");
                $date = date('Y-m-d H:i:s');
                $subscription_end = $subscription[0]->subscription_ends_at;
                if(strtotime($subscription_end) <= strtotime($date)) {
                    Session::flash('flash_message', 'Welcome <strong>' . Auth::user()->name . ' </strong> to Salsa ! ');
                    return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
                }else{
                    Session::flash('flash_message', 'Welcome <strong>' . Auth::user()->name . ' </strong> to Salsa ! ');
                    return property_exists($this, 'redirectTo') ? $this->redirectTo : 'map';
                }
            }

        }else{
            Session::flash('flash_message', 'Welcome <strong>' . Auth::user()->name . ' </strong> to Salsa ! ');
            return 'admin/dashboard';
        }
    }
}
