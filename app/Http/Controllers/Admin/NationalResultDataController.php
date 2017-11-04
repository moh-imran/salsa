<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NationalResultsData;
use App\Grade9Data;
use Illuminate\Http\Request;
use App\School;
use App\Subject;
use App\Triangles;

class NationalResultDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.nationalResultData.index');
    }

    public function getNationalResultData(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $nationalResultData = NationalResultsData::select(
            'national_results_datas.id as id', 'students_participated', 'merit_points', 'share_ae', 'share_participated',
            'schools.title as school_title', 'subjects.title as subject_title'
        )
            ->join('schools', 'schools.code' , '=', 'national_results_datas.school_code')
            ->join('subjects', 'subjects.id', '=', 'national_results_datas.subject_id');
        if(!empty($search)){
            $nationalResultData->where('students_participated', 'like', "%".$search."%")
                ->orWhere('merit_points', 'like', "%".$search."%")
                ->orWhere('share_ae', 'like', "%".$search."%")
                ->orWhere('share_participated', 'like', "%".$search."%")
                ->orWhere('schools.title', 'like', "%".$search."%")
                ->orWhere('subjects.title', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $nationalResultData->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $nationalResultData->orderBy('schools.title', 'asc');
        }
        return $nationalResultData = $nationalResultData->paginate(10);
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
        $all_subjects =  Subject::orderBy('title')->get();
        $subjects = [];
        foreach ($all_subjects as $subject){
            $subjects[$subject->id] = $subject->title;
        }

        return view('admin.nationalResultData.create', compact('schools', 'subjects'));
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
            'subject_id' => 'required',
            'students_participated' => 'required|numeric',
            'merit_points' => 'required|numeric',
            'share_ae' => 'required|numeric',
            'share_participated' => 'required|numeric'
        ]);
        $nationalResultData = $request->all();
        NationalResultsData::create($nationalResultData);
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();

        return redirect('admin/national-result-data');
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
        $all_schools =  School::orderBy('title')->get();
        $schools = [];
        foreach ($all_schools as $school){
            $schools[$school->code] = $school->title;
        }
        $all_subjects =  Subject::orderBy('title')->get();
        $subjects = [];
        foreach ($all_subjects as $subject){
            $subjects[$subject->id] = $subject->title;
        }
        $nationalResultData = NationalResultsData::find($id);

        return view('admin.nationalResultData.edit', compact('nationalResultData', 'schools', 'subjects'));
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
            'students_participated' => 'numeric',
            'merit_points' => 'numeric',
            'share_ae' => 'numeric',
            'share_participated' => 'numeric'
        ]);
//      logic for set null if empty values in form
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                $request->request->set($key, null);
            }
        }
        $nationalResultData = $request->all();
        $new_nationalResultData = NationalResultsData::find($id);
        $new_nationalResultData->students_participated = $nationalResultData['students_participated'];
        $new_nationalResultData->merit_points = $nationalResultData['merit_points'];
        $new_nationalResultData->share_ae = $nationalResultData['share_ae'];
        $new_nationalResultData->share_participated = $nationalResultData['share_participated'];
        $new_nationalResultData->save();

        //Calculate grade9 deviation values
        Grade9Data::updateGrade9DeviationValues();
        //Calculate average deviation value of schools against national results merit points
        Grade9Data::updateSalsaDeviationValues();
        //Update national share participated of a school in grade9
        NationalResultsData::updateShareParticipated();
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();

        return redirect('admin/national-result-data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NationalResultsData::find($id)->delete();
    }
}
