<?php

namespace App\Http\Controllers\Admin;

use App\SchoolSalsaValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;
use App\Triangles;
use App\Grade9Data;
use App\CommunitySalsaValue;

class SchoolSalsaValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.schoolSalsaValue.index');
    }

    public function getSchoolSalsaValues(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $schoolSalsaValues = SchoolSalsaValue::select(
            'school_salsa_values.id as id', 'bg_parents_avg_level_of_education', 'bg_share_of_newly_immigrated',
            'bg_share_of_born_abroad', 'bg_share_of_foreign_background', 'bg_share_of_boys', 'ga_actual_value_f',
            'ga_model_calc_value_b', 'ga_residual_value_f-b as ga_residual_value_f_b', 'amp_actual_value_f', 'amp_model_calc_value_b',
            'amp_residual_value_f-b as amp_residual_value_f_b', 'avg_deviation_value_in_primary_sub',
            'schools.title as school_title'
        )
            ->join('schools', 'schools.code' , '=', 'school_salsa_values.school_code');
        if(!empty($search)){
            $schoolSalsaValues->where('bg_parents_avg_level_of_education', 'like', "%".$search."%")
                ->orWhere('bg_share_of_newly_immigrated', 'like', "%".$search."%")
                ->orWhere('bg_share_of_born_abroad', 'like', "%".$search."%")
                ->orWhere('bg_share_of_foreign_background', 'like', "%".$search."%")
                ->orWhere('bg_share_of_boys', 'like', "%".$search."%")
                ->orWhere('ga_actual_value_f', 'like', "%".$search."%")
                ->orWhere('ga_model_calc_value_b', 'like', "%".$search."%")
                ->orWhere('ga_residual_value_f-b', 'like', "%".$search."%")
                ->orWhere('amp_actual_value_f', 'like', "%".$search."%")
                ->orWhere('amp_model_calc_value_b', 'like', "%".$search."%")
                ->orWhere('amp_residual_value_f-b', 'like', "%".$search."%")
                ->orWhere('avg_deviation_value_in_primary_sub', 'like', "%".$search."%")
                ->orWhere('schools.title', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $schoolSalsaValues->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $schoolSalsaValues->orderBy('schools.title', 'asc');
        }
        return $schoolSalsaValues = $schoolSalsaValues->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_schools =  School::orderBy('title')->get();
        $schools = [];
        foreach ($all_schools as $school){
            $schools[$school->code] = $school->title;
        }

        return view('admin.schoolSalsaValue.create', compact('schools'));
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
            'school_code' => 'required',
            'bg_parents_avg_level_of_education' => 'required|numeric',
            'bg_share_of_newly_immigrated' => 'required|numeric',
            'bg_share_of_born_abroad' => 'required|numeric',
            'bg_share_of_foreign_background' => 'required|numeric',
            'bg_share_of_boys' => 'required|numeric',
            'ga_actual_value_f' => 'required|numeric',
            'ga_model_calc_value_b' => 'required|numeric',
            'ga_residual_value_f-b' => 'required|numeric',
            'amp_actual_value_f' => 'required|numeric',
            'amp_model_calc_value_b' => 'required|numeric',
            'amp_residual_value_f-b' => 'required|numeric',
            'avg_deviation_value_in_primary_sub' => 'required|numeric',
        ]);
        $schoolSalsaValue = $request->all();
        SchoolSalsaValue::create($schoolSalsaValue);
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();
        return redirect('admin/school-salsa-value');
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
        $schoolSalsaValue = SchoolSalsaValue::find($id);

        $all_schools =  School::orderBy('title')->get();
        $schools = [];
        foreach ($all_schools as $school){
            $schools[$school->code] = $school->title;
        }
        return view('admin.schoolSalsaValue.edit', compact('schoolSalsaValue', 'schools'));
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
            'bg_parents_avg_level_of_education' => 'numeric',
            'bg_share_of_newly_immigrated' => 'numeric',
            'bg_share_of_born_abroad' => 'numeric',
            'bg_share_of_foreign_background' => 'numeric',
            'bg_share_of_boys' => 'numeric',
            'ga_actual_value_f' => 'numeric',
            'ga_model_calc_value_b' => 'numeric',
            'ga_residual_value_f-b' => 'numeric',
            'amp_actual_value_f' => 'numeric',
            'amp_model_calc_value_b' => 'numeric',
            'amp_residual_value_f-b' => 'numeric',
            'avg_deviation_value_in_primary_sub' => 'numeric',
        ]);
//      logic for set null if empty values in form
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                $request->request->set($key, null);
            }
        }
        $schoolSalsaValue = $request->all();
        $new_schoolSalsaValue = SchoolSalsaValue::find($id);
        $new_schoolSalsaValue->bg_parents_avg_level_of_education = $schoolSalsaValue['bg_parents_avg_level_of_education'];
        $new_schoolSalsaValue->bg_share_of_newly_immigrated = $schoolSalsaValue['bg_share_of_newly_immigrated'];
        $new_schoolSalsaValue->bg_share_of_born_abroad = $schoolSalsaValue['bg_share_of_born_abroad'];
        $new_schoolSalsaValue->bg_share_of_foreign_background = $schoolSalsaValue['bg_share_of_foreign_background'];
        $new_schoolSalsaValue->bg_share_of_boys = $schoolSalsaValue['bg_share_of_boys'];
        $new_schoolSalsaValue->ga_actual_value_f = $schoolSalsaValue['ga_actual_value_f'];
        $new_schoolSalsaValue->ga_model_calc_value_b = $schoolSalsaValue['ga_model_calc_value_b'];
        $new_schoolSalsaValue['ga_residual_value_f-b'] = $schoolSalsaValue['ga_residual_value_f-b'];
        $new_schoolSalsaValue->amp_actual_value_f = $schoolSalsaValue['amp_actual_value_f'];
        $new_schoolSalsaValue->amp_model_calc_value_b = $schoolSalsaValue['amp_model_calc_value_b'];
        $new_schoolSalsaValue['amp_residual_value_f-b'] = $schoolSalsaValue['amp_residual_value_f-b'];
        $new_schoolSalsaValue->avg_deviation_value_in_primary_sub = $schoolSalsaValue['avg_deviation_value_in_primary_sub'];
        $new_schoolSalsaValue->save();

        //Update Salsa School(s) Sub Communities
        SchoolSalsaValue::updateSalsaSchoolsSubCommunities();
        //Calculate grade9 deviation values
        Grade9Data::updateGrade9DeviationValues();
        //Calculate average deviation value of schools against national results merit points
        Grade9Data::updateSalsaDeviationValues();
        //Update community salsa values against community schools
        CommunitySalsaValue::updateCommunitySalsaValues();

        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();
        return redirect('admin/school-salsa-value');
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
