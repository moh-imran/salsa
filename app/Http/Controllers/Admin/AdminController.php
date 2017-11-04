<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Notification;
use File;
use App\User;
use App\Role;
use App\Mail\CreateAdmin;
use Auth;
use DB;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function getAdmin(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $admins = User::select('id', 'name', 'email', 'phone', DB::raw('0 as processLine, 5 as seconds, "" as time'))
            ->whereHas('roles', function ($query) {
            $query->where('title', 'admin');
            });
        $admins->with('roles');
        if(!empty($search)){
            $admins->where(function($q) use($search) {
                $q->orWhere('name', 'like', "%" . $search . "%")
                    ->orWhere('email', 'like', "%" . $search . "%")
                    ->orWhere('phone', 'like', "%" . $search . "%");
            });
        }
        if(!empty($orderBy)){
            $admins->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $admins->orderBy('name', 'asc');
        }
        return $admins = $admins->paginate(10);

    }

    public function adminActivationForm($id, $code){
        $user = User::where('id', $id)->where('active_code', $code)->first();
        if(empty($user)){
           return "you are not authorize to access this link";
        }
        return view('admin.activate', compact('user'));
    }

    public function activate($id, Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'password' => 'required|min:5'
        ]);
        $user = $request->all();
        $new_user = User::find($id);
        $user_email = $new_user->email;
        $new_user->name = $user['name'];
        $new_user->phone = $user['phone'];
        $new_user->password = bcrypt($user['password']);
        $new_user->active_code = NULL;
        $new_user->save();

        if(Auth::guard('web')->attempt([ 'email' => $user_email, 'password' => $user['password'] ])){
            return redirect('admin/dashboard');
        }else{
            return "some error occur";
        }

    }

    public function dashboard(){
        
        return view('admin.dashboard');
    }

    public function create(){
        return view('admin.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users'
        ]);
        $user = $request->all();
        $user['active_code'] = str_random(30);

        $storedUser = User::create($user);
        $role_id = Role::where('title','admin')->first()->id;
        $storedUser->roles()->attach($role_id);
//        send email here
        Mail::to($user['email'])->send(new CreateAdmin($storedUser));
        return redirect('admin/user');
    }

    public function edit($id){
        $user = User::find($id);
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, $id){
        $user_store =  User::find($id)->email;
        $email =  $user_store->email;
        $user = $request->all();
//        check if change email then send mail again to updated admin user
        if($request->email != $email){
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users'
            ]);

            $user_store->name = $user['name'];
            $user_store->email = $user['email'];
            $user_store->phone = $user['phone'];
            $user_store->active_code = str_random(30);

            Mail::to($user['email'])->send(new CreateAdmin($user_store));

        }else{
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email'
            ]);
            $user_store->name = $user['name'];
            $user_store->phone = $user['phone'];
        }
        $user_store->save();
        return redirect('admin/user');
    }

    public function destroy($id){
        $role_id = Role::where('title','admin')->first()->id;
        User::find($id)->roles()->detach($role_id);
        User::find($id)->delete();
    }
}
