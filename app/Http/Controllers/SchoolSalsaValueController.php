<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use PHPExcel;
use Mockery\CountValidator\Exception;
use PHPExcel_IOFactory;
use App\SchoolSalsaValue;
use App\CommunitySalsaValue;
use App\School;
use App\ImportErrors;
use App\AuditLog;
use App\Grade9Data;
use DB;
use App\ExcelImportMeta;
use Auth;
use App\Triangles;

class SchoolSalsaValueController extends Controller
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
            $table_name = 'school_salsa_values';
            $anything_updated = false;

            $schools = array();
            $existing_files = ExcelImportMeta::where('key', SALSA_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(3)->get();
            $recent_year = $existing_files->pluck('from_year')->max();

            //Download latest files
            if ($existing_files->count()) {
                foreach ($existing_files as $existing_file) {
                    ExcelImportMeta::saveFile($existing_file->download_url, $existing_file->relative_path_on_server);
                }
            }

            $schools = $this->fetchResults($existing_files);

            foreach ($schools as $school_code => $school) {

                $com_row = array();

                $com_row['school_code'] = $school_code;
                $community_title = array_pluck($school, 'community_title');
                $school_title = array_pluck($school, 'school_title');
                $community_title = $community_title[0];
                $school_title = $school_title[0];

                $db_school = School::where('code', $school_code);
                $existing_school_count = $db_school->count();
                if(!$existing_school_count)
                {
                    //This school does not exist in the schools table so do not include this school for the school/community salsa values calculations
                    $ImportErrors = array('table_name' => $table_name,
                        'missing_table_name' => 'schools',
                        'community_title' => $community_title,
                        'school_code' => $school_code,
                        'school_title' => $school_title
                    );

                    ImportErrors::updateOrCreate(['school_code' => $school_code, 'table_name' => $table_name], $ImportErrors);
                    continue;
                }
                $existing_school = $db_school->first();

                $com_row['community_title'] = $community_title;
                $com_row['community_code'] = $existing_school->community_code;
                $com_row['school_title'] = $school_title;
                //$com_row['is_public'] = array_pluck($school, 'community_title');

                //Use only last year data for background and actual grades. If you need to use average of three years data for background and actual grades then comment following lines and uncomment below lines to calculate average of last three years
                if(isset($school[$recent_year]))
                    $last_year = $school[$recent_year];
                elseif(isset($school[$recent_year - 1]))
                    $last_year = $school[$recent_year - 1];
                elseif(isset($school[$recent_year - 2]))
                    $last_year = $school[$recent_year - 2];

                $com_row['bg_parents_avg_level_of_education'] = (!is_null($last_year['bg_parents_avg_level_of_education'])) ? floatval($last_year['bg_parents_avg_level_of_education']) : NULL;
                $com_row['bg_share_of_newly_immigrated'] = (!is_null($last_year['bg_share_of_newly_immigrated'])) ? floatval($last_year['bg_share_of_newly_immigrated']) : NULL;
                $com_row['bg_share_of_born_abroad'] = (!is_null($last_year['bg_share_of_born_abroad'])) ? floatval($last_year['bg_share_of_born_abroad']) : NULL;
                $com_row['bg_share_of_foreign_background'] = (!is_null($last_year['bg_share_of_foreign_background'])) ? floatval($last_year['bg_share_of_foreign_background']) : NULL;
                $com_row['bg_share_of_boys'] = (!is_null($last_year['bg_share_of_boys'])) ? floatval($last_year['bg_share_of_boys']) : NULL;

                $com_row['ga_actual_value_f'] = (!is_null($last_year['ga_actual_value_f'])) ? floatval($last_year['ga_actual_value_f']) : NULL;
                $com_row['ga_model_calc_value_b'] = (!is_null($last_year['ga_model_calc_value_b'])) ? floatval($last_year['ga_model_calc_value_b']) : NULL;
                $com_row['ga_residual_value_f-b'] = (!is_null($last_year['ga_residual_value_f-b'])) ? floatval($last_year['ga_residual_value_f-b']) : NULL;

                //Use only last year data for background and actual grades. If you need to use average of three years data for background and actual grades then uncomment following lines
                /*$com_row['bg_parents_avg_level_of_education'] = array_avg(array_pluck($school, 'bg_parents_avg_level_of_education'));
                $com_row['bg_share_of_newly_immigrated'] = array_avg(array_pluck($school, 'bg_share_of_newly_immigrated'));
                $com_row['bg_share_of_born_abroad'] = array_avg(array_pluck($school, 'bg_share_of_born_abroad'));
                $com_row['bg_share_of_foreign_background'] = array_avg(array_pluck($school, 'bg_share_of_foreign_background'));
                $com_row['bg_share_of_boys'] = array_avg(array_pluck($school, 'bg_share_of_boys'));

                $com_row['ga_actual_value_f'] = array_avg(array_pluck($school, 'ga_actual_value_f'));
                $com_row['ga_model_calc_value_b'] = array_avg(array_pluck($school, 'ga_model_calc_value_b'));
                $com_row['ga_residual_value_f-b'] = array_avg(array_pluck($school, 'ga_residual_value_f-b'));*/

                $com_row['amp_actual_value_f'] = array_avg(array_pluck($school, 'amp_actual_value_f'));
                $com_row['amp_model_calc_value_b'] = array_avg(array_pluck($school, 'amp_model_calc_value_b'));
                $com_row['amp_residual_value_f-b'] = array_avg(array_pluck($school, 'amp_residual_value_f-b'));

                $AuditLog = AuditLog::where('table_name', $table_name)
                    ->where('record_id', $com_row['school_code'])
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

                    $existing_school = SchoolSalsaValue::where('school_code', $com_row['school_code']);
                    if($existing_school)
                    {
                        $update_SchoolSalsaValue_data = $com_row;
                        unset($update_SchoolSalsaValue_data['community_title']);
                        unset($update_SchoolSalsaValue_data['school_title']);
                        $existing_school->update($update_SchoolSalsaValue_data);
                    }
                    else {
                        $update_SchoolSalsaValue_data = $com_row;
                        SchoolSalsaValue::create($update_SchoolSalsaValue_data);
                    }

                    //SchoolSalsaValue::updateOrCreate(['school_code'=> $com_row['school_code']], $com_row);
                    unset($com_row['created_by']);
                    unset($com_row['updated_by']);

                    $audit_log = array('record_id' => $com_row['school_code'],
                        'table_name' => $table_name,
                        'sync_version' => $new_sync_version,
                        'last_version' => $current_version,
                        'current_version' => $new_sync_version
                    );

                    AuditLog::create($audit_log);
                }
            }

            //if($anything_updated)
            //{
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
            //}

            foreach($existing_files as $existing_file) {
                ExcelImportMeta::updateProcessed($existing_file->id);
            }
            return response()->json(['success' => 'School salsa values data imported successfully.']);
        }
        catch(\Exception $e)
        {
            echo $e->getTraceAsString();
            return $e->getMessage();
            return response()->json(['error' => 'Unexpected error occur, please try again.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function fetchResults($existing_files)
    {
        set_time_limit(0);
        try
        {
            $schools = array();
            if($existing_files->count())
            {
                foreach($existing_files as $existing_file) {
                    $path = $existing_file->relative_path_on_server;

                    $objWorksheet = $this->getWorksheets($path);
                    $ignore_list = [config('constants.DOT'), config('constants.DOUBLE_DOT')];

                    foreach ($objWorksheet->getRowIterator($existing_file->first_data_row) as $row) {
                        $cellIterator = $row->getCellIterator();
                        // even if it is not set. By default, only cells that are set will be iterated.
                        $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                        $com_row = array();

                        $school_code = '';
                        foreach ($cellIterator as $k => $cell) {

                            $val = trim($cell->getValue());

                            if($k == 6)
                            {
                                $com_row['bg_share_of_born_abroad'] = NULL;
                            }
                            elseif($k == 7)
                            {
                                $com_row['bg_share_of_foreign_background'] = NULL;
                            }

                            if($k == 0)
                            {
                                $com_row['community_title'] = $val;
                            }
                            elseif($k == 1)
                            {
                                $com_row['school_title'] = $val;
                            }
                            elseif($k == 2)
                            {
                                $school_code = $com_row['school_code'] = $val;
                            }
                            elseif($k == 3)
                            {
                                $com_row['is_public'] = $val;
                            }
                            elseif($val != '' && !in_array($val, $ignore_list))
                            {
                                if($k == 4)
                                {
                                    $com_row['bg_parents_avg_level_of_education'] = getFloatValue($val);
                                }
                                elseif($k == 5)
                                {
                                    $com_row['bg_share_of_newly_immigrated'] = getFloatValue($val);
                                }
                                elseif($k == 6)
                                {
                                    $com_row['bg_share_of_born_abroad'] = getFloatValue($val);
                                }
                                elseif($k == 7)
                                {
                                    $com_row['bg_share_of_foreign_background'] = getFloatValue($val);
                                }
                                elseif($k == 8)
                                {
                                    $com_row['bg_share_of_boys'] = getFloatValue($val);
                                }
                                elseif($k == 9)
                                {
                                    $com_row['ga_actual_value_f'] = getFloatValue($val);
                                }
                                elseif($k == 10)
                                {
                                    $com_row['ga_model_calc_value_b'] = getFloatValue($val);
                                }
                                elseif($k == 11)
                                {
                                    $com_row['ga_residual_value_f-b'] = getFloatValue($val);
                                }
                                elseif($k == 12)
                                {
                                    $com_row['amp_actual_value_f'] = getFloatValue($val);
                                }
                                elseif($k == 13)
                                {
                                    $com_row['amp_model_calc_value_b'] = getFloatValue($val);
                                }
                                elseif($k == 14)
                                {
                                    $com_row['amp_residual_value_f-b'] = getFloatValue($val);
                                }
                            }
                        }
                        $schools[$school_code][$existing_file->from_year] = $com_row;
                    }
                }
            }
            return $schools;
        }
        catch(\Exception $e)
        {
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
        //$path = storage_path('app/files/Salsa Data Excel Import/exp_salsa_'. $year .'.xlsx');

        $inputFileType = 'Excel2007';
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
