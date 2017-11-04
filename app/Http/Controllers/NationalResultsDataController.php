<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use PHPExcel;
use PHPExcel_IOFactory;
use App\NationalResultsData;
use App\Subject;
use App\School;
use App\ImportErrors;
use App\AuditLog;
use App\Grade9Data;
use DB;
use App\ExcelImportMeta;
use Auth;
use App\Triangles;


class NationalResultsDataController extends Controller
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
            $SoResults_file = ExcelImportMeta::where('key', 'exp_ap9_so_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($SoResults_file->count())
            {
                $SoResults_file = $SoResults_file[0];
            }

            $NoResults_file = ExcelImportMeta::where('key', 'exp_ap9_no_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($NoResults_file->count())
            {
                $NoResults_file = $NoResults_file[0];
            }

            $Ap9Results_file = ExcelImportMeta::where('key', 'exp_ap9_masven_gr_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($Ap9Results_file->count())
            {
                $Ap9Results_file = $Ap9Results_file[0];
            }

            //Download latest files
            if ($SoResults_file) {
                ExcelImportMeta::saveFile($SoResults_file->download_url, $SoResults_file->relative_path_on_server);
            }
            if ($NoResults_file) {
                ExcelImportMeta::saveFile($NoResults_file->download_url, $NoResults_file->relative_path_on_server);
            }
            if ($Ap9Results_file) {
                ExcelImportMeta::saveFile($Ap9Results_file->download_url, $Ap9Results_file->relative_path_on_server);
            }

            $soResults = $this->fetchSoResults($SoResults_file);
            $noResults = $this->fetchNoResults($NoResults_file);
            $ap9Results = $this->fetchAp9Results($Ap9Results_file);

            $all_results = array_merge($soResults, $noResults, $ap9Results);

            $anything_updated = false;

            foreach ($all_results as $subject => $schools) {
                $subject = explode('-', $subject);
                $subject = trim($subject[0]);
                $subject = explode('(', $subject);
                $subject = trim($subject[0]);

                $objSubject = Subject::updateOrCreate(['title' => $subject], array('title' => $subject));
                $subject_id = $objSubject->id;

                foreach ($schools as $school_code => $school) {

                    $existing_school = School::where('code', $school_code)->count();
                    if(!$existing_school)
                    {
                        $ImportErrors = array('table_name' => 'national_results_datas',
                            'missing_table_name' => 'schools',
                            'community_title' => $school['community_title'],
                            'school_code' => $school_code,
                            'school_title' => $school['school_title']
                        );

                        ImportErrors::updateOrCreate(['school_code' => $school_code, 'table_name' => 'national_results_datas', 'missing_table_name' => 'schools'], $ImportErrors);
                        continue;
                    }

                    $com_row['subject'] = $subject;
                    $com_row['school_code'] = $school_code;

                    if(config('constants.DOT') != $school['students_participated'] && config('constants.DOUBLE_DOT') != $school['students_participated'])
                    {
                        $com_row['students_participated'] = (int) getFloatValue($school['students_participated']);
                    }
                    else
                    {
                        unset($com_row['students_participated']);
                    }

                    if(config('constants.DOT') != $school['merit_points'] && config('constants.DOUBLE_DOT') != $school['merit_points'])
                    {
                        $com_row['merit_points'] = getFloatValue($school['merit_points']);
                    }
                    else
                    {
                        unset($com_row['merit_points']);
                    }

                    if(config('constants.DOT') != $school['share_ae'] && config('constants.DOUBLE_DOT') != $school['share_ae'])
                    {
                        $com_row['share_ae'] = getFloatValue($school['share_ae']);
                    }
                    else
                    {
                        unset($com_row['share_ae']);
                    }

                    $record_id = $school_code .'-'. $subject;

                    $AuditLog = AuditLog::where('table_name', 'national_results_datas')
                        ->where('record_id', $record_id)
                        ->orderBy('id', 'desc')
                        ->take(1)->first();

                    $is_modified = true;
                    $new_sync_version = serialize($com_row);
                    $current_version = $new_sync_version;

                    if ($AuditLog && $AuditLog->count()) {
                        if ($AuditLog->sync_version === $new_sync_version) {
                            $is_modified = false;
                        }
                        $current_version = $AuditLog->current_version;
                    }

                    if (true === $is_modified) {

                        $anything_updated = true;

                        $com_row['subject_id'] = $subject_id;
                        $com_row['created_by'] = Auth::user()->id;
                        $com_row['updated_by'] = Auth::user()->id;

                        NationalResultsData::updateOrCreate(['school_code' => $com_row['school_code'], 'subject_id' => $com_row['subject_id']], $com_row);

                        unset($com_row['created_by']);
                        unset($com_row['updated_by']);

                        unset($com_row['subject_id']);

                        $audit_log = array('record_id' => $record_id,
                            'table_name' => 'national_results_datas',
                            'sync_version' => $new_sync_version,
                            'last_version' => $current_version,
                            'current_version' => $new_sync_version
                        );

                        AuditLog::create($audit_log);
                    }
                }
            }

            //if($anything_updated)
            //{
                //Calculate grade9 deviation values
                Grade9Data::updateGrade9DeviationValues();
                //Calculate average deviation value of schools against national results merit points
                Grade9Data::updateSalsaDeviationValues();
                //Update national share participated of a school in grade9
                NationalResultsData::updateShareParticipated();
                //Calculate school level and subject level warning triangles
                Triangles::updateTriangles();

            //}

            ExcelImportMeta::updateProcessed($SoResults_file->id);
            ExcelImportMeta::updateProcessed($NoResults_file->id);
            ExcelImportMeta::updateProcessed($Ap9Results_file->id);

            return response()->json(['success' => 'National results imported successfully.']);
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
    private function fetchSoResults($existing_file)
    {
        set_time_limit(0);
        try
        {
            $path = $existing_file->relative_path_on_server;

            $objWorksheet = $this->getSoWorksheets($path);
            return $this->fetchSubjectResults($objWorksheet, $existing_file->first_data_row);
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
    private function fetchSubjectResults($objWorksheet, $first_data_row)
    {
        $subjects = array();
        $sheetCount = $objWorksheet->getSheetCount() - 1;

        foreach ($objWorksheet->getWorksheetIterator() as $key => $worksheet)
        {
            if($sheetCount == $key)
            {
                break;
            }
            $title = $worksheet->getTitle();
            $schools = array();

            foreach ($worksheet->getRowIterator($first_data_row) as $row) {
                //echo '    Row number - ' , $row->getRowIndex() , EOL;
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

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
                    elseif($k == 4)
                    {
                        $com_row['students_participated'] = $cell->getValue();
                    }
                    elseif($k == 7)
                    {
                        $com_row['share_ae'] = $cell->getValue();
                    }
                    elseif($k == 10)
                    {
                        $com_row['merit_points'] = $cell->getValue();
                    }
                }
                $schools[$com_row['school_code']] = $com_row;
            }
            $subjects[$title] = $schools;
        }

        return $subjects;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function fetchNoResults($existing_file)
    {
        set_time_limit(0);
        try
        {
            $path = $existing_file->relative_path_on_server;
            $objWorksheet = $this->getNoWorksheets($path);
            return $this->fetchSubjectResults($objWorksheet, $existing_file->first_data_row);
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
    private function fetchAp9Results($existing_file)
    {
        set_time_limit(0);
        try
        {
            $path = $existing_file->relative_path_on_server;
            $objWorksheet = $this->getAp9Worksheets($path);
            return $this->fetchSubjectResults($objWorksheet, $existing_file->first_data_row);
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
    private function getSoWorksheets($path)
    {
        //$path = storage_path('app/files/NationalTestResultsDataExcelImport/exp_ap9_so_2013_2015.xlsx');

        $inputFileType = 'Excel2007';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        /**  Advise the Reader that we only want to load cell data  **/
        $objReader->setReadDataOnly(true);

        /**  Load only the rows and columns that match our filter to PHPExcel  **/
        $objPHPExcel = $objReader->load($path);

        return $objPHPExcel;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getNoWorksheets($path)
    {
        //$path = storage_path('app/files/NationalTestResultsDataExcelImport/exp_ap9_no_2013_2015.xlsx');

        $inputFileType = 'Excel2007';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        /**  Advise the Reader that we only want to load cell data  **/
        $objReader->setReadDataOnly(true);

        /**  Load only the rows and columns that match our filter to PHPExcel  **/
        $objPHPExcel = $objReader->load($path);

        return $objPHPExcel;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getAp9Worksheets($path)
    {
        //$path = storage_path('app/files/NationalTestResultsDataExcelImport/exp_ap9_2013_2015.xlsx');

        $inputFileType = 'Excel2007';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        /**  Advise the Reader that we only want to load cell data  **/
        $objReader->setReadDataOnly(true);

        /**  Load only the rows and columns that match our filter to PHPExcel  **/
        $objPHPExcel = $objReader->load($path);

        return $objPHPExcel;
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
