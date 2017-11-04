<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Session;
use App\School;
use App\Community;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $params = $request->all();
        //return $params;
        if(!empty($params))
        {
            if(!$this->validate($request, [
                'support_email' => 'email|max:255',
            ]))
            {
                Session::flash('error', 'Please enter valid email address.');
            };
            //logic for set null if empty values in form
//            print_r($request->input());
//            
//            exit;
            foreach ($request->input() as $key => $value) {

                if (empty($value)) {
                    $request->request->set($key, null);
                }
                
                $setting = Setting::where('key', $key)->first();
//                print_r($key);
//                echo '<br>';
                if($key == 'selected_community'){
                    
                    $com_code = Community::where('title', $value)->first(['code']);                    
                    $setting->key_options = $com_code->code;                    
                    $setting->value = $value;
                }
                elseif($key == 'single_community_flag'){
                    $setting = Setting::where('key', 'selected_community')->first();
                    $setting->status = $value;
                }
                else{
                    $setting->value = $value;
                }
                
                $setting->save();
            }
            
            Session::flash('success', 'Settings updated successfully!');
            return redirect('admin/setting');
        }
 
        $settings = Setting::select()->paginate(20);
        return view('admin.setting.index', compact('settings'));
    }

    public function changeStatus($id, $status){
        if($status == 0){
            return Setting::find($id)->inactiveSetting($id);
        }else{
            return Setting::withTrashed()->find($id)->activeSetting($id);
        }

    }

    public function getSetting(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $settings = Setting::withTrashed();
        if(!empty($search)){
            $settings->where('title', 'like', "%".$search."%")
                ->orWhere('group', 'like', "%".$search."%")
                ->orWhere('key', 'like', "%".$search."%")
                ->orWhere('key_options', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $settings->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $settings->orderBy('title', 'asc');
        }
        return $settings = $settings->paginate(10);
    }
    
    public function get_Community_Setting(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $settings = Setting::withTrashed();
        if(!empty($search)){
            $settings->where('title', 'like', "%".$search."%")
                ->orWhere('group', 'like', "%".$search."%")
                ->orWhere('key', 'like', "%".$search."%")
                ->orWhere('key_options', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $settings->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $settings->orderBy('title', 'asc');
        }
        return $settings = $settings->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'title' => 'required|string',
            'key' => 'required|string|unique:settings',
            //'group' => 'required|string|unique:settings',
            //'key_options' => 'required',
            //'value' => 'required',
        ]);
        $setting = $request->all();
        Setting::create($setting);
        Session::flash('success', 'Settings successfully updated!');
        return redirect('admin/setting');
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
        $setting = Setting::find($id);
        return view('admin.setting.edit', compact('setting'));
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
        $this->validate($request, [
            'title' => 'required|string',
            'key' => 'required|string|unique:settings,key,'.$id,
        ]);
//      logic for set null if empty values in form
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                $request->request->set($key, null);
            }
        }
        $setting = $request->all();
        $new_setting = Setting::find($id);

        $new_setting->title = $setting['title'];
        $new_setting->group = $setting['group'];
        $new_setting->key = $setting['key'];
        $new_setting->key_options = $setting['key_options'];
        $new_setting->value = $setting['value'];
        $new_setting->save();

        Session::flash('success', 'Settings successfully updated!');
        return redirect('admin/setting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Setting::find($id)->delete();
    }
    
    public function selectCommunity($search){
        $search = str_replace('**s**', '/', $search);
        return School::select('community_code', 'community_title')
            ->where('community_title', 'like', '%'.$search.'%')
            ->groupBy('community_title')
            ->groupBy('community_code')->get();
    }
     
    public function set_single_community_flag(){
        echo 'set community';
        exit;
    }
}
