<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Subscriptions;
//use App\Subscription;
use Illuminate\Support\Facades\Session;
use DateTime;
use App\UserRole;
use App\ChildrenInfo;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.client.index');
    }

    public function getClient(Request $request){
        
        //exit;
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $clients = User::whereHas('roles', function ($query) {
            $query->where('title', 'client');
        });
        $clients->with('subscriptions');
        if(!empty($search)){
            if(strtolower($search) == 'inactive'){
                $search_inactive = '0';
                $clients->where('status', $search_inactive);
            }else{
                $search_active = '1';
                $clients->where('status', $search_active);
            }
            $clients->where(function($q) use($search) {
                $q->orWhere('name', 'like', "%" . $search . "%")
                    ->orWhere('email', 'like', "%" . $search . "%")
                    ->orWhere('phone', 'like', "%" . $search . "%")
                    ->orWhere('trial_ends_at', 'like', "%" . $search . "%");
            });
        }
        
        if(!empty($orderBy)){
            $clients->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $clients->orderBy('name', 'asc');
        }
//        $clients->with('user_children')->where(function($q){
//            $q->WhereNotNull('');
//        });
        $clients->with('user_children');
                
        $clients = $clients->paginate(10);
        $child_count = 0;
        $client_index = 0;
        foreach($clients as $clint){
            //print_r($clint->user_children);exit;
//            foreach($clients[1]->user_children as $child_arr)
//            {
            if($clint->user_children){
                if($clint->user_children->child_1_age != 0 && $clint->user_children->child_1_age != null){
                    $child_count++;
                }
                if($clint->user_children->child_2_age != 0 && $clint->user_children->child_2_age != null){
                    $child_count++;
                }
                if($clint->user_children->child_3_age != 0 && $clint->user_children->child_3_age != null){
                    $child_count++;
                }
                if($clint->user_children->child_4_age != 0 && $clint->user_children->child_4_age != null){
                    $child_count++;
                }
                if($clint->user_children->child_5_age != 0 && $clint->user_children->child_5_age != null){
                    $child_count++;
                }
//            }
            }
             $clients[$client_index]->child_count   = $child_count;
             $client_index++;
             $child_count = 0;
            //print_r($child_count);exit;
        }
        
        return $clients;

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::where('id', $id)->with(['user_children', 'user_subscription'])->first();
//        return $client;
        return view('admin.client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $client = User::find($id);
        $subscription = Subscriptions::where('user_id', $id)->first();
        if($subscription){
            $client->stripe_plan = $subscription->stripe_plan;
//             $createDate = new DateTime($subscription->subscription_ends_at);
//             $strip_time = $createDate->format('Y-m-d'); 
//             $date = '2012-05-29 00:00:00';
             $strip_time = date('Y-n-j', strtotime($subscription->subscription_ends_at));
             $client->subscription_ends_at = $strip_time;
             
        }
       // $client = $client->toArray();
        
//        echo '<pre>';
//        print_r($client);exit;
        
        return view('admin.client.edit', compact('client'));
    }
    
    public function get_one_customer($id){
        
        $client = User::find($id);
        $subscription = Subscriptions::where('user_id', $id)->first();
        if($subscription){
            //$client->stripe_plan = $subscription->stripe_plan;
//             $createDate = new DateTime($subscription->subscription_ends_at);
//             $strip_time = $createDate->format('Y-m-d'); 
//             $date = '2012-05-29 00:00:00';
             $strip_time = date('Y-n-j', strtotime($subscription->subscription_ends_at));
             $client->subscription_ends_at = $strip_time;
             
        }
        $children_inf =  ChildrenInfo::where('user_id', $id)->first();
            if($children_inf){
                $children_inf = $children_inf->toArray();
            }            
            return response()->json(['status' => 'success', 'data' =>[$children_inf, $client], 'message' => 'sucessfully returning data.']);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $data = $request->all();
        $this->validate($request, [
                    'name' => 'required|max:255',
                    'email' => 'required|email '                                       
        ]);
        
        $client = User::find($id);
        $client->name = $data['name'];
        $client->email = $data['email'];
        $client->phone = $data['phone'];
        $client->save();
        
        $subscription = Subscriptions::where('user_id', $id)->first();
        if($subscription){
    
        if($data['stripe_plan']){
            $subscription->stripe_plan = $data['stripe_plan'];
        }
        if($data['subscription_ends_at']){
            $subscription->subscription_ends_at = $data['subscription_ends_at'];
        }
        
        $subscription->save();
    }
        Session::flash('success','Customer updated successfully.');
        return redirect('admin/client');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function save_one_customer(Request $request){
        
        $data = $request->all();

//            print_r($data); exit;
        if($data){
            $id = $data[5];
            $user = User::where('id', $id)->first();
            $user->name = $data[0];
            $user->email = $data[1];
            $user->phone = $data[2];
            //$user->subscription_ends_at = $data[3];
            $user->save();
            
            $childreninfo = ChildrenInfo::where('user_id', $id)->first();
            if(!($childreninfo)){
                $childreninfo = new ChildrenInfo;
                $childreninfo->user_id = $id;                
            }          
            
//            print_r($data[4]);
//            exit;
            $childre_data = $data[4];
            if($childre_data){
                                        
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
            } 
            else{
                $childreninfo->child_1_age = $childreninfo->child_2_age = $childreninfo->child_3_age = $childreninfo->child_4_age = $childreninfo->child_5_age = '';
                $childreninfo->save();
            }
                    Session::flash('flash_message','Customer updated successfully.');
                    //return redirect('admin/client');
                    return response()->json(['status' => 'success', 'message' => 'Information Saved Successfully']);
        }
    }
    public function destroy($id)
    {
        
       UserRole::where('user_id',$id)->delete();       
       Subscriptions::where('user_id',$id)->delete();
       //$result = Subscription::where('user_id', $id)->delete();
       ChildrenInfo::where('user_id', $id)->delete();
       User::where('id', $id)->delete();
       
       //print_r($result);
        return "ok";
    }
}
