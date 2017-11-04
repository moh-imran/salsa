<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CommunitySalsaValue;
use App\Community;
class CommunitySalsaValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.communitySalsaValue.index');
    }

    public function getCommunitySalsaValue(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $communitySalsaValues = CommunitySalsaValue::select();
        if(!empty($search)){
            $communitySalsaValues->where('community_title', 'like', "%".$search."%")
                ->orWhere('ga_actual_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('ga_model_calc_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('ga_residual_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('amp_actual_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('amp_model_calc_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('amp_residual_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('public_ga_actual_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('public_ga_model_calc_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('public_ga_residual_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('public_amp_actual_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('public_amp_model_calc_value_avg_three_yrs', 'like', "%".$search."%")
                ->orWhere('public_amp_residual_value_avg_three_yrs', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $communitySalsaValues->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $communitySalsaValues->orderBy('community_title', 'asc');
        }
        return $communitySalsaValues = $communitySalsaValues->paginate(10);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_communities =  Community::orderBy('title')->get();
        $communities = [];
        foreach ($all_communities as $community){
            $communities[$community->code] = $community->title;
        }
        return view('admin.communitySalsaValue.create', compact('communities'));
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
            'community_code' => 'required',
            'ga_actual_value_avg_three_yrs' => 'required|numeric',
            'ga_model_calc_value_avg_three_yrs' => 'required|numeric',
            'ga_residual_value_avg_three_yrs' => 'required|numeric',
            'amp_actual_value_avg_three_yrs' => 'required|numeric',
            'amp_model_calc_value_avg_three_yrs' => 'required|numeric',
            'amp_residual_value_avg_three_yrs' => 'required|numeric',
            'public_ga_actual_value_avg_three_yrs' => 'required|numeric',
            'public_ga_model_calc_value_avg_three_yrs' => 'required|numeric',
            'public_ga_residual_value_avg_three_yrs' => 'required|numeric',
            'public_amp_actual_value_avg_three_yrs' => 'required|numeric',
            'public_amp_model_calc_value_avg_three_yrs' => 'required|numeric',
            'public_amp_residual_value_avg_three_yrs' => 'required|numeric',
        ]);
        $communitySalsaValue = $request->all();
        $communitySalsaValue['community_title'] =  $community_title = Community::where('code', $request->community_code)->first()->title;
        CommunitySalsaValue::create($communitySalsaValue);
        return redirect('admin/community-salsa-value');
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
        $communitySalsaValue = CommunitySalsaValue::find($id);
        return view('admin.communitySalsaValue.edit', compact('communitySalsaValue'));
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
            'ga_actual_value_avg_three_yrs' => 'numeric',
            'ga_model_calc_value_avg_three_yrs' => 'numeric',
            'ga_residual_value_avg_three_yrs' => 'numeric',
            'amp_actual_value_avg_three_yrs' => 'numeric',
            'amp_model_calc_value_avg_three_yrs' => 'numeric',
            'amp_residual_value_avg_three_yrs' => 'numeric',
            'public_ga_actual_value_avg_three_yrs' => 'numeric',
            'public_ga_model_calc_value_avg_three_yrs' => 'numeric',
            'public_ga_residual_value_avg_three_yrs' => 'numeric',
            'public_amp_actual_value_avg_three_yrs' => 'numeric',
            'public_amp_model_calc_value_avg_three_yrs' => 'numeric',
            'public_amp_residual_value_avg_three_yrs' => 'numeric',
        ]);
//      logic for set null if empty values in form
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                $request->request->set($key, null);
            }
        }
        $communitySalsaValue = $request->all();
        
        $save = CommunitySalsaValue::find($id);

        $save->ga_actual_value_avg_three_yrs = $communitySalsaValue['ga_actual_value_avg_three_yrs'];
        $save->ga_model_calc_value_avg_three_yrs = $communitySalsaValue['ga_model_calc_value_avg_three_yrs'];
        $save->ga_residual_value_avg_three_yrs = $communitySalsaValue['ga_residual_value_avg_three_yrs'];
        $save->amp_actual_value_avg_three_yrs = $communitySalsaValue['amp_actual_value_avg_three_yrs'];
        $save->amp_model_calc_value_avg_three_yrs = $communitySalsaValue['amp_model_calc_value_avg_three_yrs'];
        $save->amp_residual_value_avg_three_yrs = $communitySalsaValue['amp_residual_value_avg_three_yrs'];
        $save->public_ga_actual_value_avg_three_yrs = $communitySalsaValue['public_ga_actual_value_avg_three_yrs'];
        $save->public_ga_model_calc_value_avg_three_yrs = $communitySalsaValue['public_ga_model_calc_value_avg_three_yrs'];
        $save->public_ga_residual_value_avg_three_yrs = $communitySalsaValue['public_ga_residual_value_avg_three_yrs'];
        $save->public_amp_actual_value_avg_three_yrs = $communitySalsaValue['public_amp_actual_value_avg_three_yrs'];
        $save->public_amp_model_calc_value_avg_three_yrs = $communitySalsaValue['public_amp_model_calc_value_avg_three_yrs'];
        $save->public_amp_residual_value_avg_three_yrs = $communitySalsaValue['public_amp_residual_value_avg_three_yrs'];
        $save->save();
        return redirect('admin/community-salsa-value');
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
