<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grade9Data;
use App\NationalResultsData;
use App\School;
use App\Subject;
use DB;
use App\Triangles;

class Grade9DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grade9data = Grade9Data::select()->paginate(10);
        return view('admin.grade9data.index', compact('grade9data'));
    }

    public function getGrade9data(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $grade9data = Grade9Data::select(
                'grade9_datas.id as id', 'students_enrolled', 'merit_points', 'share_ae',
                'schools.title as school_title', 'subjects.title as subject_title'
            )
            ->join('schools', 'schools.code' , '=', 'grade9_datas.school_code')
            ->join('subjects', 'subjects.id', '=', 'grade9_datas.subject_id');
        if(!empty($search)){
            $grade9data->where('students_enrolled', 'like', "%".$search."%")
                ->orWhere('merit_points', 'like', "%".$search."%")
                ->orWhere('share_ae', 'like', "%".$search."%")
                ->orWhere('schools.title', 'like', "%".$search."%")
                ->orWhere('subjects.title', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $grade9data->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $grade9data->orderBy('schools.title', 'asc');
        }
        return $grade9data = $grade9data->paginate(10);
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

        return view('admin.grade9data.create', compact('schools', 'subjects'));
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
            'students_enrolled' => 'required|numeric',
            'merit_points' => 'required|numeric',
            'share_ae' => 'required|numeric'
        ]);
        $grade9data = $request->all();
        Grade9Data::create($grade9data);
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();
        return redirect('admin/grade9data');
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
        $grade9data = Grade9Data::find($id);
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
        return view('admin.grade9data.edit', compact('grade9data', 'schools', 'subjects'));
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
            'students_enrolled' => 'numeric',
            'merit_points' => 'numeric',
            'share_ae' => 'numeric'
        ]);
//      logic for set null if empty values in form
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                $request->request->set($key, null);
            }
        }
        $grade9data = $request->all();
        $new_grade9data = Grade9Data::find($id);
        $new_grade9data->students_enrolled = $grade9data['students_enrolled'];
        $new_grade9data->merit_points = $grade9data['merit_points'];
        $new_grade9data->share_ae = $grade9data['share_ae'];
        $new_grade9data->save();

        //Calculate grade9 deviation values
        Grade9Data::updateGrade9DeviationValues();
        //Calculate average deviation value of schools against national results merit points
        Grade9Data::updateSalsaDeviationValues();
        //Update national share participated of a school in grade9
        NationalResultsData::updateShareParticipated();

        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();
        return redirect('admin/grade9data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Grade9Data::find($id)->delete();
    }
}
