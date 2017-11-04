<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Validator;
use App\helpers\helpers;
use App\ChildrenInfo;
use stdClass;
use Auth;
use Mail;
use Hash;
use App\User;
use App\Subscriptions;
use App\Mail\ContactEmailAlert;

class ContactController extends Controller {

    public function index() {
        return view('contact');
    }

    public function send_feedback(Request $request) {
        
//      //  print_r($request->all());        
        $data = $request->all();


        $validator = Validator::make(
                        array(
                    'name' => $data['name'],
                    'email' => $data['email'],
                    //'subject' => $data['subject'],
                    'message' => $data['message']
                        ), array(
                    'name' => 'required|max:255',
                    'email' => 'required|email',
                    //'subject' => 'required|max:255',
                    'message' => 'required|max:1500'
                        )
        );

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        } else {

            $email_data = new StdClass;
            $email_data->name = $data['name'];
            $email_data->to = CONTACT_US_EMAIL;
            $email_data->from = $data['email'];
            $email_data->message = $data['message'];
            $email_data->email_template = CONTACT_US_EMAIL_TEMPLATE;

            /*Mail::send($email_data->email_template, ['user' => $email_data], function ($m) use ($email_data) {
                        $m->from($email_data->from, $email_data->name);
                        $m->to($email_data->to, 'Salsa')->bcc('hafizshahid@gmail.com')->subject('FeedBack From User!');
                    });*/

            try {
                $sent = Mail::to(CONTACT_US_EMAIL)->bcc('shahzadatta@gmail.com')->send(new ContactEmailAlert($email_data));
            }
            catch(Exception $e) {
                //echo $e->getMessage();
            }

           return back()->with('success', 'Ditt meddelande har skickats.');         
        }
        // print_r($resp);
    }

    public function add_children_data(Request $request) {

        //print_r($request->all());
        
        $data = $request->all();

        if(Auth::check()) {
            
            $childreninfo = ChildrenInfo::where('user_id', Auth::id())->first();
            if(!($childreninfo)){
                $childreninfo = new ChildrenInfo;
                $childreninfo->user_id = Auth::id();                
            }          
            
            
            $post_code = $data[0];
            $childre_data = $data[1];
            $user_email = $data[2];
            $user_pass = $data[3];
            
            $user = User::where('id',Auth::id())->first();
                    if($user_email){
                    if($user->email != $user_email){
                        $user->email = $user_email;
                        $user->save();
                    }
                    }
                    if($user_pass){
                        $user->password = Hash::make($user_pass);
                        $user->save();
                    }
                    $childreninfo->post_code = $post_code;                    
                    $childreninfo->child_1_age = $childreninfo->child_2_age = $childreninfo->child_3_age = $childreninfo->child_4_age = $childreninfo->child_5_age = '';
                    foreach ($childre_data as $child) {

                        if ($child['id'] == 0) {
                            $childreninfo->child_1_age = $child['value'];
                        } else if ($child['id'] == 1) {
                            $childreninfo->child_2_age = $child['value'];
                        } else if ($child['id'] == 2) {
                            $childreninfo->child_3_age = $child['value'];
                        } else if ($child['id'] == 3) {
                            $childreninfo->child_4_age = $child['value'];
                        } else if ($child['id'] == 4) {
                            $childreninfo->child_5_age = $child['value'];
                        }
                        
                    }
                    $childreninfo->save();
                    
                    return response()->json(['status' => 'success', 'message' => 'Information Saved Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User is not logged in.']);
        }
    }
    
    public function account_data(){
        
        $user = User::where('id',Auth::id())->first();
        $user = $user->toArray();
        if($user){
            $children_inf =  ChildrenInfo::where('user_id', Auth::id())->first();
            if($children_inf){
                $children_inf = $children_inf->toArray();
            }   
            $subscription_data = Subscriptions::where('user_id', Auth::id())->orderBy('subscription_ends_at', 'desc')->first();
            return response()->json(['status' => 'success', 'data' =>[$children_inf, $user, $subscription_data], 'message' => 'User is registered already.']);
        }
        else{
            return response()->json(['status' => 'error', 'data' =>'', 'message' => 'User has to provide account data yet.']);
        }        
    }

}
