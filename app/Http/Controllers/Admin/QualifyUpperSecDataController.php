<?php

namespace App\Http\Controllers\Admin;

use App\QualifyUpperSecData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;
class QualifyUpperSecDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.qualifyUpperSecData.index');
    }

    public function getQualifyUpperSecData(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $qualifyUpperSecData = QualifyUpperSecData::select(
            'qualify_upper_sec_datas.id as id', 'share_qualify_vocational_program', 'share_qualify_arts_aestetichs_program',
            'share_qualify_econ_philos_socialsc_program', 'share_qualify_natural_science_tech_program', 'share_not_qualified',
            'schools.title as school_title'
        )
            ->join('schools', 'schools.code' , '=', 'qualify_upper_sec_datas.school_code');
        if(!empty($search)){
            $qualifyUpperSecData->where('share_qualify_vocational_program', 'like', "%".$search."%")
                ->orWhere('share_qualify_arts_aestetichs_program', 'like', "%".$search."%")
                ->orWhere('share_qualify_econ_philos_socialsc_program', 'like', "%".$search."%")
                ->orWhere('share_qualify_natural_science_tech_program', 'like', "%".$search."%")
                ->orWhere('share_not_qualified', 'like', "%".$search."%")
                ->orWhere('schools.title', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $qualifyUpperSecData->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $qualifyUpperSecData->orderBy('schools.title', 'asc');
        }
        return $qualifyUpperSecData = $qualifyUpperSecData->paginate(10);
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

        return view('admin.qualifyUpperSecData.create', compact('schools'));
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
            'share_qualify_vocational_program' => 'required|numeric',
            'share_qualify_arts_aestetichs_program' => 'required|numeric',
            'share_qualify_econ_philos_socialsc_program' => 'required|numeric',
            'share_qualify_natural_science_tech_program' => 'required|numeric',
            'share_not_qualified' => 'required|numeric'
        ]);
        $qualifyUpperSecData = $request->all();
        QualifyUpperSecData::create($qualifyUpperSecData);
        return redirect('admin/qualify-upper-sec-data');
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
        $qualifyUpperSecData = QualifyUpperSecData::find($id);
        $all_schools =  School::orderBy('title')->get();
        $schools = [];
        foreach ($all_schools as $school){
            $schools[$school->code] = $school->title;
        }

        return view('admin.qualifyUpperSecData.edit', compact('qualifyUpperSecData', 'schools'));
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
            'share_qualify_vocational_program' => 'numeric',
            'share_qualify_arts_aestetichs_program' => 'numeric',
            'share_qualify_econ_philos_socialsc_program' => 'numeric',
            'share_qualify_natural_science_tech_program' => 'numeric',
            'share_not_qualified' => 'numeric'
        ]);
//      logic for set null if empty values in form
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                $request->request->set($key, null);
            }
        }
        $qualifyUpperSecData = $request->all();
        $new_qualifyUpperSecData= QualifyUpperSecData::find($id);
        $new_qualifyUpperSecData->share_qualify_vocational_program = $qualifyUpperSecData['share_qualify_vocational_program'];
        $new_qualifyUpperSecData->share_qualify_arts_aestetichs_program = $qualifyUpperSecData['share_qualify_arts_aestetichs_program'];
        $new_qualifyUpperSecData->share_qualify_econ_philos_socialsc_program = $qualifyUpperSecData['share_qualify_econ_philos_socialsc_program'];
        $new_qualifyUpperSecData->share_qualify_natural_science_tech_program = $qualifyUpperSecData['share_qualify_natural_science_tech_program'];
        $new_qualifyUpperSecData->share_not_qualified = $qualifyUpperSecData['share_not_qualified'];
        $new_qualifyUpperSecData->save();
        return redirect('admin/qualify-upper-sec-data');
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
