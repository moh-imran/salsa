<?php

namespace App\Http\Controllers\Admin;

use App\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Triangles;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subject.index');
    }

    public function getSubject(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $Subjects = Subject::select();
        if(!empty($search)){
            $Subjects->where('title', 'like', "%".$search."%");
            if(strtolower($search) == 'yes'){
                $search = '1';
                $Subjects->orWhere('use_for_deviation',$search);
            }elseif (strtolower($search) == 'no'){
                $search = '0';
                $Subjects->orWhere('use_for_deviation', $search);
            }


        }
        if(!empty($orderBy)){
            $Subjects->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $Subjects->orderBy('title', 'asc');
        }
        return $Subjects = $Subjects->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subject.create');
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
            'use_for_deviation' => 'required'
        ]);
        $subject = $request->all();

        Subject::create($subject);
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();

        return redirect('admin/subject');
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
        $subject = Subject::find($id);
        return view('admin.subject.edit', compact('subject'));
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
            'title' => 'required|string'
        ]);

        $subject = $request->all();

        $subject_obj = Subject::find($id);
        $subject_obj->title = $subject['title'];
        $subject_obj->use_for_deviation = $subject['use_for_deviation'];
        $subject_obj->save();
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();

        return redirect('admin/subject');
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
