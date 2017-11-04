<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\ChildrenInfo;
use App\UserRole;
class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.children.index');
    }

    public function getClient(Request $request){
                
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
//        $clients = User::whereHas('roles', function ($query) {
//            $query->where('title', 'client');
//        });
        $user_ids = UserRole::where('role_id', 3)->get()->pluck(['user_id'])->toArray();
         
        if(!empty($search)){
            $clients = User::whereIN('id', $user_ids);
            if(strtolower($search) == 'inactive'){
                $search_inactive = '0';
                $clients->where('status', $search_inactive);
            }else{
                $search_active = '1';
                $clients->where('status', $search_active);
            }
            $clients->where(function($q) use($search) {
                $q->orWhere('name', 'like', "%" . $search . "%")
                    ->orWhere('email', 'like', "%" . $search . "%");                    
            });
            //$clients = $clients->where('name', 'like', "%" . $search . "%")->paginate(10);
            //print_r($clients->toArray());
        }
        
        else{
            $clients = User::whereIN('id', $user_ids);
        }                  

        $clients = $clients->with('user_children')->paginate(10);
        
//        foreach($clients as $client){
//           
//            $client->childrens = ChildrenInfo::where('user_id', $client->id)->first(); 
//          
//        }
        
        

        
//        if(!empty($orderBy)){
//            $clients->orderBy($order[0], ($order[1])? $order[1]: 'asc');
//        }else{
//            $clients->orderBy('name', 'asc');
//        }
         
        
        
        return $clients ;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
