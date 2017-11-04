<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use PHPExcel;
use PHPExcel_IOFactory;
use App\QualifyUpperSecData;
use App\ExcelImportMeta;
use App\School;
use App\ImportErrors;
use App\AuditLog;
use Auth;

class QualifyUpperSecDataController extends Controller
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
            $existing_file = ExcelImportMeta::where('key', QUALIFIED_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($existing_file->count())
            {
                $existing_file = $existing_file[0];
            }

            //Download latest files
            if ($existing_file) {
                ExcelImportMeta::saveFile($existing_file->download_url, $existing_file->relative_path_on_server);
            }

            $schools = $this->fetchResults($existing_file);

            foreach ($schools as $school) {

                $com_row = array();
                $school_code = $school['school_code'];

                $existing_school = School::where('code', $school_code)->count();
                if(!$existing_school)
                {
                    $ImportErrors = array('table_name' => 'qualify_upper_sec_datas',
                        'missing_table_name' => 'schools',
                        'community_title' => $school['community_title'],
                        'school_code' => $school_code,
                        'school_title' => $school['school_title']
                    );

                    ImportErrors::updateOrCreate(['school_code' => $school_code, 'table_name' => 'qualify_upper_sec_datas'], $ImportErrors);
                    continue;
                }

                $com_row['school_code'] = $school_code;

                if(config('constants.DOT') != $school['share_qualify_vocational_program'] && config('constants.DOUBLE_DOT') != $school['share_qualify_vocational_program'])
                    $com_row['share_qualify_vocational_program'] = getFloatValue($school['share_qualify_vocational_program']);

                if(config('constants.DOT') != $school['share_qualify_arts_aestetichs_program'] && config('constants.DOUBLE_DOT') != $school['share_qualify_arts_aestetichs_program'])
                    $com_row['share_qualify_arts_aestetichs_program'] = getFloatValue($school['share_qualify_arts_aestetichs_program']);

                if(config('constants.DOT') != $school['share_qualify_econ_philos_socialsc_program'] && config('constants.DOUBLE_DOT') != $school['share_qualify_econ_philos_socialsc_program'])
                    $com_row['share_qualify_econ_philos_socialsc_program'] = getFloatValue($school['share_qualify_econ_philos_socialsc_program']);

                if(config('constants.DOT') != $school['share_qualify_natural_science_tech_program'] && config('constants.DOUBLE_DOT') != $school['share_qualify_natural_science_tech_program'])
                    $com_row['share_qualify_natural_science_tech_program'] = getFloatValue($school['share_qualify_natural_science_tech_program']);

                if(config('constants.DOT') != $school['share_not_qualified'] && config('constants.DOUBLE_DOT') != $school['share_not_qualified'])
                    $com_row['share_not_qualified'] = getFloatValue($school['share_not_qualified']);


                $AuditLog = AuditLog::where('table_name', 'qualify_upper_sec_datas')
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
                    $com_row['created_by'] = Auth::user()->id;
                    $com_row['updated_by'] = Auth::user()->id;
                    QualifyUpperSecData::updateOrCreate(['school_code'=> $com_row['school_code']], $com_row);
                    unset($com_row['created_by']);
                    unset($com_row['updated_by']);

                    $audit_log = array('record_id' => $com_row['school_code'],
                        'table_name' => 'qualify_upper_sec_datas',
                        'sync_version' => $new_sync_version,
                        'last_version' => $current_version,
                        'current_version' => $new_sync_version
                    );

                    AuditLog::create($audit_log);
                }
            }
            ExcelImportMeta::updateProcessed($existing_file->id);
            return response()->json(['success' => 'Qualify upper sec data imported successfully.']);
        }
        catch(\Exception $e)
        {
            //return $e->getMessage();
            return response()->json(['error' => 'Unexpected error occur, please try again.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function fetchResults($existing_file)
    {
        set_time_limit(0);
        try
        {
            $path = $existing_file->relative_path_on_server;

            $objWorksheet = $this->getWorksheets($path);

            $schools = array();
            foreach ($objWorksheet->getRowIterator($existing_file->first_data_row) as $row) {
                $cellIterator = $row->getCellIterator();
                // even if it is not set. By default, only cells that are set will be iterated.
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                $com_row = array();

                foreach ($cellIterator as $k => $cell) {
                    if($k == 0)
                    {
                        $com_row['community_title'] = $cell->getValue();
                    }
                    elseif($k == 1)
                    {
                        $com_row['school_title'] = $cell->getValue();
                    }
                    elseif($k == 2)
                    {
                        $com_row['school_code'] = $cell->getValue();
                    }
                    elseif($k == 5)
                    {
                        $com_row['share_qualify_vocational_program'] = $cell->getValue();
                    }
                    elseif($k == 6)
                    {
                        $com_row['share_qualify_arts_aestetichs_program'] = $cell->getValue();
                    }
                    elseif($k == 7)
                    {
                        $com_row['share_qualify_econ_philos_socialsc_program'] = $cell->getValue();
                    }
                    elseif($k == 8)
                    {
                        $com_row['share_qualify_natural_science_tech_program'] = $cell->getValue();
                    }
                    elseif($k == 9)
                    {
                        $com_row['share_not_qualified'] = $cell->getValue();
                    }
                }
                $schools[$com_row['school_code']] = $com_row;
            }
            return $schools;
        }
        catch(\Exception $e)
        {
            //return $e->getMessage();
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
        //$path = storage_path('app/files/QualifiedForUpperSecondaryExcepImport/exp_behorig_gy_2016.xlsx');

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
