<?php

namespace App\Http\Controllers\Admin;

use App\CommunitySalsaValue;
use App\SchoolPupilTeacherStat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;
class SchoolPupilTeacherStatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.schoolPupilTeacherStat.index');
    }

    public function getSchoolPupilTeacherStat(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $schoolPupilTeacherStats = SchoolPupilTeacherStat::select(
            'school_pupil_teacher_stats.id as id', 'students_grade1', 'students_grade2', 'students_grade3',
            'students_grade4', 'students_grade5', 'students_grade6', 'students_grade7', 'students_grade8',
            'students_grade9', 'teachers_count', 'students_per_teacher', 'percent_teacher_pedagogical_degree',
            'schools.title as school_title'
        )
            ->join('schools', 'schools.code' , '=', 'school_pupil_teacher_stats.school_code');
        if(!empty($search)){
            $schoolPupilTeacherStats->where('students_grade1', 'like', "%".$search."%")
                ->orWhere('students_grade2', 'like', "%".$search."%")
                ->orWhere('students_grade3', 'like', "%".$search."%")
                ->orWhere('students_grade4', 'like', "%".$search."%")
                ->orWhere('students_grade5', 'like', "%".$search."%")
                ->orWhere('students_grade6', 'like', "%".$search."%")
                ->orWhere('students_grade7', 'like', "%".$search."%")
                ->orWhere('students_grade8', 'like', "%".$search."%")
                ->orWhere('students_grade9', 'like', "%".$search."%")
                ->orWhere('teachers_count', 'like', "%".$search."%")
                ->orWhere('students_per_teacher', 'like', "%".$search."%")
                ->orWhere('percent_teacher_pedagogical_degree', 'like', "%".$search."%")
                ->orWhere('schools.title', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $schoolPupilTeacherStats->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $schoolPupilTeacherStats->orderBy('schools.title', 'asc');
        }
        return $schoolPupilTeacherStats = $schoolPupilTeacherStats->paginate(10);
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
        return view('admin.schoolPupilTeacherStat.create', compact('schools'));
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
            'students_grade1' => 'required|numeric',
            'students_grade2' => 'required|numeric',
            'students_grade3' => 'required|numeric',
            'students_grade4' => 'required|numeric',
            'students_grade5' => 'required|numeric',
            'students_grade6' => 'required|numeric',
            'students_grade7' => 'required|numeric',
            'students_grade8' => 'required|numeric',
            'students_grade9' => 'required|numeric',
            'teachers_count' => 'required|numeric',
            'students_per_teacher' => 'required|numeric',
            'percent_teacher_pedagogical_degree' => 'required|numeric',
        ]);
        $schoolPupilTeacherStat = $request->all();
        SchoolPupilTeacherStat::create($schoolPupilTeacherStat);
        return redirect('admin/school-pupil-teacher-stat');
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
        $schoolPupilTeacherStat = SchoolPupilTeacherStat::find($id);

        $all_schools =  School::orderBy('title')->get();
        $schools = [];
        foreach ($all_schools as $school){
            $schools[$school->code] = $school->title;
        }
        return view('admin.schoolPupilTeacherStat.edit', compact('schoolPupilTeacherStat'));
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
            'students_grade1' => 'numeric',
            'students_grade2' => 'numeric',
            'students_grade3' => 'numeric',
            'students_grade4' => 'numeric',
            'students_grade5' => 'numeric',
            'students_grade6' => 'numeric',
            'students_grade7' => 'numeric',
            'students_grade8' => 'numeric',
            'students_grade9' => 'numeric',
            'teachers_count' => 'numeric',
            'students_per_teacher' => 'numeric',
            'percent_teacher_pedagogical_degree' => 'numeric',
        ]);
//      logic for set null if empty values in form
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                $request->request->set($key, null);
            }
        }
        $schoolPupilTeacherStat = $request->all();
        $new_schoolPupilTeacherStat = SchoolPupilTeacherStat::find($id);
        $new_schoolPupilTeacherStat->students_grade1 = $schoolPupilTeacherStat['students_grade1'];
        $new_schoolPupilTeacherStat->students_grade2 = $schoolPupilTeacherStat['students_grade2'];
        $new_schoolPupilTeacherStat->students_grade3 = $schoolPupilTeacherStat['students_grade3'];
        $new_schoolPupilTeacherStat->students_grade4 = $schoolPupilTeacherStat['students_grade4'];
        $new_schoolPupilTeacherStat->students_grade5 = $schoolPupilTeacherStat['students_grade5'];
        $new_schoolPupilTeacherStat->students_grade6 = $schoolPupilTeacherStat['students_grade6'];
        $new_schoolPupilTeacherStat->students_grade7 = $schoolPupilTeacherStat['students_grade7'];
        $new_schoolPupilTeacherStat->students_grade8 = $schoolPupilTeacherStat['students_grade8'];
        $new_schoolPupilTeacherStat->students_grade9 = $schoolPupilTeacherStat['students_grade9'];
        $new_schoolPupilTeacherStat->teachers_count = $schoolPupilTeacherStat['teachers_count'];
        $new_schoolPupilTeacherStat->students_per_teacher = $schoolPupilTeacherStat['students_per_teacher'];
        $new_schoolPupilTeacherStat->percent_teacher_pedagogical_degree = $schoolPupilTeacherStat['percent_teacher_pedagogical_degree'];
        $new_schoolPupilTeacherStat->save();

        return redirect('admin/school-pupil-teacher-stat');
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
