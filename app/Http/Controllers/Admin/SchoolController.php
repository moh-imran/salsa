<?php

namespace App\Http\Controllers\Admin;

use App\Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::select()->paginate(10);
        return view('admin.school.index', compact('schools'));
    }

    public function changeStatus($id, $status){
        if($status == 0){
            return School::find($id)->inactiveSchool($id);
        }else{
            return School::withTrashed()->find($id)->activeSchool($id);
        }

    }

    public function getSchool(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $schools = School::withTrashed();
        if(!empty($search)){
            $schools->where('code', 'like', "%".$search."%")
                ->orWhere('title', 'like', "%".$search."%")
                ->orWhere('community_title', 'like', "%".$search."%")
                ->orWhere('is_public', 'like', "%".$search."%")
                ->orWhere('street_address', 'like', "%".$search."%")
                ->orWhere('post_number', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $schools->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $schools->orderBy('title', 'asc');
        }
        return $schools = $schools->paginate(10);
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

        return view('admin.school.create', compact('communities'));
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
            'code' => 'required|string|unique:schools',
            'title' => 'required|string',
            'community_code' => 'required',
            'is_public' => 'required',
            'street_address' => 'required|string'
        ]);
        $school = $request->all();
        $school['community_title'] =  $community_title = Community::where('code', $request->community_code)->first()->title;
        $places = places($school['street_address']);
        $school['lat'] = $places['lat'];
        $school['long'] = $places['lng'];
        School::create($school);
        return redirect('admin/school');
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
        $all_communities =  Community::orderBy('title')->get();
        $communities = [];
        foreach ($all_communities as $community){
            $communities[$community->code] = $community->title;
        }
        $school = School::find($id);
        if($school->is_public == 'Kommunal'){
            $school->is_public = 1;
        }elseif ($school->is_public == 'Enskild'){
            $school->is_public = 2;
        }else{
            $school->is_public = 3;
        }
        return view('admin.school.edit', compact('school', 'communities'));
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
            'community_code' => 'required',
            'street_address' => 'string'
        ]);
//      logic for set null if empty values in form
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                $request->request->set($key, null);
            }
        }
        $school = $request->all();
        $school['community_title'] =  $community_title = Community::where('code', $request->community_code)->first()->title;

        $new_school = School::find($id);
//        check if address change then update lat and lng
        if(!empty($school['street_address']) && $new_school['street_address'] != $school['street_address']){
            $places = places($school['street_address']);
            if(!empty($places['lat'] && !empty($places['lng']))) {
                $new_school->lat = $places['lat'];
                $new_school->long = $places['lng'];
            }
        }
        $new_school->title = $school['title'];
        $new_school->community_code = $school['community_code'];
        $new_school->community_title = $school['community_title'];
        $new_school->is_public = $school['is_public'];
        $new_school->street_address = $school['street_address'];
        $new_school->post_area = $school['post_area'];
        $new_school->save();

        return redirect('admin/school');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        School::find($id)->delete();
    }
}
