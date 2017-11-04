<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Triangles;
use Session;
use Auth;

class TrianglesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.triangles.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTriangles()
    {
        return $triangles = Triangles::select()->paginate(20);
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
        $triangle = Triangles::find($id);
        return view('admin.triangles.edit', compact('triangle'));
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
        $triangle = $request->all();

        $triangle['status'] = (isset($triangle['status']))? '1': '0';
        $triangle['is_free'] = (isset($triangle['is_free']))? '1': '0';

        $this->validate($request, [
            'merit_points_warning_value' => 'required|string',
            'participation_warning_value' => 'required|string',
            //'status' => 'required|string',
            //'is_free' => 'required|string',
        ]);
        Triangles::where('id', $id)->update([
            'merit_points_warning_value' => $triangle['merit_points_warning_value'],
            'participation_warning_value' => $triangle['participation_warning_value'],
            'status' => $triangle['status'],
            'is_free' => $triangle['is_free'],
            'updated_by' => Auth::user()->id,
            //'created_by' => $triangle['created_by'],
        ]);

        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();

        Session::flash('success', 'Triangle successfully updated!');

        return redirect('admin/triangles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Triangles::find($id)->delete();
        return "ok";
    }
}
