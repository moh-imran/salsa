<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use PHPExcel;
use PHPExcel_IOFactory;
use App\School;
use App\AuditLog;
use App\ExcelImportMeta;
use Auth;
use App\Triangles;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
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
    public function import()
    {
        set_time_limit(0);
        try
        {
            $anything_updated = false;

            $existing_file = ExcelImportMeta::where('title_key', SCHOOLS_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($existing_file->count())
            {
                $existing_file = $existing_file[0];
            }

            //Download latest files
            try {
                if ($existing_file) {
                    ExcelImportMeta::saveFile($existing_file->download_url, $existing_file->relative_path_on_server);
                }
            }
            catch(Exception $ex) {
            }

            $path = $existing_file->relative_path_on_server;
            $objWorksheet = $this->getWorksheets($path);

            $modified_array = array();
            $not_modified_array = array();
            foreach ($objWorksheet->getRowIterator($existing_file->first_data_row) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                // even if it is not set.
                // By default, only cells
                // that are set will be
                // iterated.

                foreach ($cellIterator as $k => $cell) {

                    if($k == 0)
                    {
                        $com_row['is_public'] = $cell->getValue();
                    }
                    elseif($k == 4)
                    {
                        $com_row['community_code'] = $cell->getValue();
                    }
                    elseif($k == 5)
                    {
                        $com_row['community_title'] = $cell->getValue();
                    }
                    elseif($k == 6)
                    {
                        $com_row['code'] = $cell->getValue();
                    }
                    elseif($k == 7)
                    {
                        $com_row['title'] = $cell->getValue();
                    }
                    elseif($k == 11)
                    {
                        $com_row['street_address'] = $cell->getValue();
                    }
                    elseif($k == 12)
                    {
                        $com_row['post_number'] = $cell->getValue();
                    }
                    elseif($k == 13)
                    {
                        $com_row['post_area'] = $cell->getValue();
                    }
                    elseif($k == 38)
                    {
                        $com_row['grade9'] = $cell->getValue();
                    }

                    //Grindstuskolan,   Mogårdsvägen 10-12,     14343,          VÅRBY,              Huddinge
                    //School Name,      Postal Address,         Zip code,       Post Area,          Community Title
                    //NAMN,             BESÖKSADRESS,           BESÖKSPOSTNR,   BESÖKSPOSTORT,      KOMMUNNAMN
                }
                //return $com_row;
                if(!isset($com_row['grade9']) || !$com_row['grade9'])
                {
                    $update_sql = "update schools set post_area = '". $com_row['post_area'] ."' where code = '". $com_row['code'] ."'";
                    $update_result = DB::select(DB::raw($update_sql));

                    continue;
                }
                //return $com_row;

                /*$address = $com_row['street_address'] ."+". $com_row['post_number'];
                $url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&region=Sweden";
                // We get the JSON results from this request
                $geo = file_get_contents($url);
                // We convert the JSON to an array
                $geo = json_decode($geo, true);
                // If everything is cool
                if ($geo['status'] = 'OK') {
                    // We set our values
                    $com_row['lat'] = $geo['results'][0]['geometry']['location']['lat'];
                    $com_row['long'] = $geo['results'][0]['geometry']['location']['lng'];
                }*/

                $AuditLog = AuditLog::where('table_name', 'schools')
                    ->where('record_id', $com_row['code'])
                    ->orderBy('id', 'desc')
                    ->take(1)->first();

                $is_modified = true;
                $new_sync_version = serialize($com_row);
                $current_version = $new_sync_version;

                if($AuditLog && $AuditLog->count())
                {
                    if($AuditLog->sync_version ===  $new_sync_version)
                    {
                        $is_modified = false;
                    }
                    $current_version = $AuditLog->current_version;
                }

                if(true === $is_modified)
                {
                    $anything_updated = true;
                    $com_row['created_by'] = Auth::user()->id;
                    $com_row['updated_by'] = Auth::user()->id;
                    $com_row['status'] = '1';

                    $existing_school = School::where('code', $com_row['code']);
                    if($existing_school)
                    {
                        $update_school_data = $com_row;
                        unset($update_school_data['grade9']);
                        $existing_school->update($update_school_data);
                    }
                    else {
                        School::create($com_row);
                    }

                    //School::updateOrCreate(['code'=> $com_row['code']], $com_row);


                    unset($com_row['created_by']);
                    unset($com_row['updated_by']);

                    $audit_log = array('record_id' => $com_row['code'],
                        'table_name' => 'schools',
                        'sync_version' => $new_sync_version,
                        'last_version' => $current_version,
                        'current_version' => $new_sync_version
                    );

                    AuditLog::create($audit_log);
                    $modified_array[$com_row['code']] = $com_row;
                }
                else
                {
                    $not_modified_array[$com_row['code']] = $com_row;
                }
            }
            //Update School(s) Sub Communities
            School::updateSchoolsSubCommunities();
            //Calculate school level and subject level warning triangles
            Triangles::updateTriangles();

            ExcelImportMeta::updateProcessed($existing_file->id);

            return response()->json(['success' => 'Schools imported successfully.']);
        }
        catch(\Exception $e)
        {
            //echo $e->getTraceAsString();
            return $e->getMessage();
            return response()->json(['error' => 'Unexpected error occur, please try again.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getWorksheets($path)
    {
        $inputFileType = 'Excel5';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        /**  Advise the Reader that we only want to load cell data  **/
        $objReader->setReadDataOnly(true);

        $sheetnames = array(0);
        $objReader->setLoadSheetsOnly($sheetnames);

        /**  Load only the rows and columns that match our filter to PHPExcel  **/
        $objPHPExcel = $objReader->load($path);

        $objWorksheet = $objPHPExcel->getSheet(0);

        return $objWorksheet;
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
}
