<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Subject;
use App\schools;
use App\Grade9Data;
use App\NationalResultsData;
class TrianglesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        //
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
    
    public function download(){
        
        set_time_limit(0);        
      $query_result =  DB::select(DB::raw('SELECT s.code AS School_Code, s.title AS School_Name, subjects.title AS Subject, g9.students_enrolled AS Students_Enrolled, nd.students_participated AS Students_Participated, (
nd.students_participated / g9.students_enrolled
) *100 AS Percent_Participation, g9.merit_points AS G9_Merit_Points, nd.merit_points AS NT_Merit_Points, (
g9.merit_points - nd.merit_points
) AS Deviation
FROM grade9_datas g9
INNER JOIN subjects ON g9.subject_id = subjects.id
INNER JOIN schools s ON g9.school_code = s.code
INNER JOIN national_results_datas nd ON nd.school_code = s.code
AND nd.subject_id = subjects.id
INNER JOIN triangles t ON t.subject_id = subjects.id
WHERE subjects.use_for_deviation =1
AND (
t.merit_points_warning_value < ABS( g9.merit_points - nd.merit_points ) 
OR t.participation_warning_value > ABS( (
nd.students_participated / g9.students_enrolled
) *100 )
)
ORDER BY subjects.title, s.title'));

        header('Content-Type: application/excel');
        header('Content-Disposition: attachment; filename="Subject Warning Triangles.csv"');
        //ob_end_clean();
        ///// write to csv file
        $fp = fopen('php://output', 'w');
        
        $csv_header = array('School_Code', 'School_Name', 'Subject', 'Students_Enrolled', 'Students_Participated', 'Percent_Participation', 'G9_Merit_Points' ,'NT_Merit_Points', 'Deviation');;
        //$data_arr = $query_result->toArray();
        fputcsv($fp,$csv_header , ',');
        foreach($query_result as $line){
            $arr = array($line->School_Code, $line->School_Name, $line->Subject, $line->Students_Enrolled, $line->Students_Participated, $line->Percent_Participation, $line->G9_Merit_Points ,$line->NT_Merit_Points, $line->Deviation);
            //echo '<br>';
         fputcsv($fp,$arr , ',');
        }
        
        fclose($fp);
      //print_r($query_result);
    }
}
