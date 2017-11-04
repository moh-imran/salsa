<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\UserRole;
use Illuminate\Http\Request;
//use App\Http\Requests\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Redirect;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/subscribe';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function showRegistrationForm()
    {
        return view('user.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator =  Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ],[
            'name.required' => 'Var vänlig fyll i det här fältet.',
            'password.required' => 'Var vänlig fyll i det här fältet.',
            'email.required' => 'Ange en giltig e-postadress.',
            'email.unique' => 'E-postmeddelandet har redan tagits.',
            'password.min' => 'Lösenordet måste bestå av minst sex tecken.'
        ]
           );
        
            
            //return redirect('register')->withErrors($validator);
           
                //$errors = $validator->messages();
                //return redirect('register')->with('errors', $errors);
                Session::flash('password', $data['password']);
                return $validator;
                //return Redirect::to('register')->withInput($data)->withErrors($validator->messages());

            //return redirect('register')->withErrors($validator, $data);
            //print_r($validator->all);exit;
            //return [$validator, $data];
    

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {        
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    protected function registered(Request $request, $user)
    {
        $user_role = new UserRole;
        
        $user_role->user_id = $user->id;
        $user_role->role_id = 3;
        $user_role->save();
//        echo 'i can over-rided something here if i want to';
//        print_r($user->id);
//        exit;
    }
}
