<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use PHPExcel;
use PHPExcel_IOFactory;
use App\SchoolPupilTeacherStat;
use App\AuditLog;
use App\School;
use App\ImportErrors;
use App\ExcelImportMeta;
use Auth;

class SchoolPupilTeacherStatController extends Controller
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
            $schools_file = ExcelImportMeta::where('key', SCHOOLS_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($schools_file->count())
                $schools_file = $schools_file[0];

            $school_counts_file = ExcelImportMeta::where('key', 'exp_personal_gr_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($school_counts_file->count())
                $school_counts_file = $school_counts_file[0];

            $schools_degrees_file = ExcelImportMeta::where('key', 'exp_pers_amne_gr_skola_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($schools_degrees_file->count())
                $schools_degrees_file = $schools_degrees_file[0];

            //Download latest files
            if ($schools_file) {
                ExcelImportMeta::saveFile($schools_file->download_url, $schools_file->relative_path_on_server);
            }
            if ($school_counts_file) {
                ExcelImportMeta::saveFile($school_counts_file->download_url, $school_counts_file->relative_path_on_server);
            }
            if ($schools_degrees_file) {
                ExcelImportMeta::saveFile($schools_degrees_file->download_url, $schools_degrees_file->relative_path_on_server);
            }

            $schools = $this->fetchSchoolsStats($schools_file);
            $school_counts = $this->fetchSchoolCountsStats($school_counts_file);
            $school_degrees = $this->fetchSchoolDegreesStats($schools_degrees_file);

            foreach ($schools as $com_row) {

                $school_code = $com_row['school_code'];

                $existing_school = School::where('code', $school_code)->count();
                if(!$existing_school)
                {
                    $ImportErrors = array('table_name' => 'school_pupil_teacher_stats',
                        'missing_table_name' => 'schools',
                        'community_code' => $com_row['community_code'],
                        'community_title' => $com_row['community_title'],
                        'school_code' => $school_code,
                        'school_title' => $com_row['school_title']
                    );

                    ImportErrors::updateOrCreate(['school_code' => $school_code, 'table_name' => 'school_pupil_teacher_stats'], $ImportErrors);
                    continue;
                }

                if(array_key_exists($com_row['school_code'], $school_counts))
                {
                    $com_row['teachers_count'] = getFloatValue($school_counts[$com_row['school_code']]['teachers_count']);
                    $com_row['students_per_teacher'] = getFloatValue($school_counts[$com_row['school_code']]['students_per_teacher']);
                }
                else
                {
                    //We can add log entry in ImportErrors
                }

                if(array_key_exists($com_row['school_code'], $school_degrees))
                {
                    $com_row['percent_teacher_pedagogical_degree'] = getFloatValue($school_degrees[$com_row['school_code']]['percent_teacher_pedagogical_degree']);
                }
                else
                {
                    //We can add log entry in ImportErrors
                }

                $AuditLog = AuditLog::where('table_name', 'school_pupil_teacher_stats')
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
                    SchoolPupilTeacherStat::updateOrCreate(['school_code'=> $com_row['school_code']], $com_row);
                    unset($com_row['created_by']);
                    unset($com_row['updated_by']);

                    $audit_log = array('record_id' => $com_row['school_code'],
                        'table_name' => 'school_pupil_teacher_stats',
                        'sync_version' => $new_sync_version,
                        'last_version' => $current_version,
                        'current_version' => $new_sync_version
                    );

                    AuditLog::create($audit_log);
                }
            }

            ExcelImportMeta::updateProcessed($schools_file->id);
            ExcelImportMeta::updateProcessed($school_counts_file->id);
            ExcelImportMeta::updateProcessed($schools_degrees_file->id);

            return response()->json(['success' => 'School pupil teachers imported successfully.']);
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
    private function fetchSchoolsStats($existing_file)
    {
        set_time_limit(0);
        try
        {
            $path = $existing_file->relative_path_on_server;

            $objWorksheet = $this->getSchoolsWorksheet($path);

            $schools = array();
            foreach ($objWorksheet->getRowIterator($existing_file->first_data_row) as $row) {
                $cellIterator = $row->getCellIterator();
                // even if it is not set. By default, only cells that are set will be iterated.
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                foreach ($cellIterator as $k => $cell) {

                    if($k == 4)
                    {
                        $com_row['community_code'] = $cell->getValue();
                    }
                    elseif($k == 5)
                    {
                        $com_row['community_title'] = $cell->getValue();
                    }
                    elseif($k == 6)
                    {
                        $com_row['school_code'] = $cell->getValue();
                    }
                    elseif($k == 7)
                    {
                        $com_row['school_title'] = $cell->getValue();
                    }
                    elseif($k == 30)
                    {
                        $com_row['students_grade1'] = $cell->getValue();
                    }
                    elseif($k == 31)
                    {
                        $com_row['students_grade2'] = $cell->getValue();
                    }
                    elseif($k == 32)
                    {
                        $com_row['students_grade3'] = $cell->getValue();
                    }
                    elseif($k == 33)
                    {
                        $com_row['students_grade4'] = $cell->getValue();
                    }
                    elseif($k == 34)
                    {
                        $com_row['students_grade5'] = $cell->getValue();
                    }
                    elseif($k == 35)
                    {
                        $com_row['students_grade6'] = $cell->getValue();
                    }
                    elseif($k == 36)
                    {
                        $com_row['students_grade7'] = $cell->getValue();
                    }
                    elseif($k == 37)
                    {
                        $com_row['students_grade8'] = $cell->getValue();
                    }
                    elseif($k == 38)
                    {
                        $com_row['students_grade9'] = $cell->getValue();
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
    private function fetchSchoolCountsStats($existing_file)
    {
        set_time_limit(0);
        try
        {
            $path = $existing_file->relative_path_on_server;

            $objWorksheet = $this->getSchoolCountsWorksheet($path);

            $schools = array();
            foreach ($objWorksheet->getRowIterator($existing_file->first_data_row) as $row) {
                $cellIterator = $row->getCellIterator();
                // even if it is not set. By default, only cells that are set will be iterated.
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
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
                    elseif($k == 7)
                    {
                        $com_row['teachers_count'] = floatval($cell->getValue());
                    }
                    elseif($k == 11)
                    {
                        $com_row['students_per_teacher'] = floatval($cell->getValue());
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
    private function fetchSchoolDegreesStats($existing_file)
    {
        set_time_limit(0);
        try
        {
            $path = $existing_file->relative_path_on_server;

            $objWorksheet = $this->getSchoolDegreesWorksheet($path);

            $schools = array();
            foreach ($objWorksheet->getRowIterator($existing_file->first_data_row) as $row) {
                $cellIterator = $row->getCellIterator();
                // even if it is not set. By default, only cells that are set will be iterated.
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,

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
                    elseif($k == 9)
                    {
                        $com_row['percent_teacher_pedagogical_degree'] = floatval($cell->getValue());
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
    private function getSchoolsWorksheet($path)
    {
        //$path = storage_path('app/files/Skolenhetsregistret_201608.xls');
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        $objWorksheet = $objPHPExcel->getSheet(0);

        return $objWorksheet;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getSchoolCountsWorksheet($student_counter_path)
    {
        //$student_counter_path = storage_path('app/files/exp_personal_gr_2015.xlsx');

        $inputFileType = 'Excel2007';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        /**  Advise the Reader that we only want to load cell data  **/
        $objReader->setReadDataOnly(true);

        $sheetnames = array(0);
        $objReader->setLoadSheetsOnly($sheetnames);

        /**  Load only the rows and columns that match our filter to PHPExcel  **/
        $objPHPExcel = $objReader->load($student_counter_path);

        $objWorksheet = $objPHPExcel->getSheet(0);

        return $objWorksheet;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getSchoolDegreesWorksheet($degree_path)
    {
        //$degree_path = storage_path('app/files/exp_pers_amne_gr_skola_2015.xlsx');

        $inputFileType = 'Excel2007';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        /**  Advise the Reader that we only want to load cell data  **/
        $objReader->setReadDataOnly(true);

        $sheetnames = array(0);
        $objReader->setLoadSheetsOnly($sheetnames);

        /**  Load only the rows and columns that match our filter to PHPExcel  **/
        $objPHPExcel = $objReader->load($degree_path);

        $objWorksheet = $objPHPExcel->getSheet(0);

        return $objWorksheet;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importPupilTeacherStat()
    {
        set_time_limit(0);
        try
        {

            $student_counter_path = storage_path('app/files/exp_personal_gr_2015.xlsx');
            $degree_path = storage_path('app/files/exp_pers_amne_gr_skola_2015.xlsx');

            $path = storage_path('app/files/Skolenhetsregistret_201608.xls');

            $objPHPExcel = PHPExcel_IOFactory::load($path);

            //$objWorksheet = $objPHPExcel->getActiveSheet();
            $objWorksheet = $objPHPExcel->getSheet(0);

            $modified_array = array();
            $not_modified_array = array();
            foreach ($objWorksheet->getRowIterator(2) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                // even if it is not set.
                // By default, only cells
                // that are set will be
                // iterated.

                foreach ($cellIterator as $k => $cell) {

                    if($k == 6)
                    {
                        $com_row['school_code'] = $cell->getValue();
                    }
                    elseif($k == 30)
                    {
                        $com_row['students_grade1'] = $cell->getValue();
                    }
                    elseif($k == 31)
                    {
                        $com_row['students_grade2'] = $cell->getValue();
                    }
                    elseif($k == 32)
                    {
                        $com_row['students_grade3'] = $cell->getValue();
                    }
                    elseif($k == 33)
                    {
                        $com_row['students_grade4'] = $cell->getValue();
                    }
                    elseif($k == 34)
                    {
                        $com_row['students_grade5'] = $cell->getValue();
                    }
                    elseif($k == 35)
                    {
                        $com_row['students_grade6'] = $cell->getValue();
                    }
                    elseif($k == 36)
                    {
                        $com_row['students_grade7'] = $cell->getValue();
                    }
                    elseif($k == 37)
                    {
                        $com_row['students_grade8'] = $cell->getValue();
                    }
                    elseif($k == 38)
                    {
                        $com_row['students_grade9'] = $cell->getValue();
                    }
                }

                $AuditLog = AuditLog::where('table_name', 'school_pupil_teacher_stats')
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
                    SchoolPupilTeacherStat::updateOrCreate(['school_code'=> $com_row['school_code']], $com_row);

                    $audit_log = array('record_id' => $com_row['school_code'],
                        'table_name' => 'school_pupil_teacher_stats',
                        'sync_version' => $new_sync_version,
                        'last_version' => $current_version,
                        'current_version' => $new_sync_version
                    );

                    AuditLog::create($audit_log);
                    $modified_array[$com_row['school_code']] = $com_row;
                }
                else
                {
                    $not_modified_array[$com_row['school_code']] = $com_row;
                }
            }
            return response()->json(['success' => 'School pupil teachers imported successfully.']);
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
    public function importPupilStudentStat()
    {
        set_time_limit(0);
        try
        {

            return $this->fetchSchoolsStats();

            $degree_path = storage_path('app/files/exp_pers_amne_gr_skola_2015.xlsx');

            $student_counter_path = storage_path('app/files/exp_personal_gr_2015.xlsx');

            $inputFileType = 'Excel2007';
            /**  Create a new Reader of the type defined in $inputFileType  **/
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

            /**  Advise the Reader that we only want to load cell data  **/
            $objReader->setReadDataOnly(true);

            $sheetnames = array(0);
            $objReader->setLoadSheetsOnly($sheetnames);

            /**  Load only the rows and columns that match our filter to PHPExcel  **/
            $objPHPExcel = $objReader->load($student_counter_path);

            $objWorksheet = $objPHPExcel->getSheet(0);

            $modified_array = array();
            $not_modified_array = array();
            foreach ($objWorksheet->getRowIterator(9) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                // even if it is not set.
                // By default, only cells
                // that are set will be
                // iterated.

                foreach ($cellIterator as $k => $cell) {

                    if($k == 2)
                    {
                        $com_row['school_code'] = $cell->getValue();
                    }
                    elseif($k == 6)
                    {
                        $com_row['teachers_count'] = floatval($cell->getValue());
                    }
                    elseif($k == 10)
                    {
                        $com_row['students_per_teacher'] = floatval($cell->getValue());
                    }
                }

                $AuditLog = AuditLog::where('table_name', 'school_pupil_teacher_stats')
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
                    $updated = SchoolPupilTeacherStat::where('school_code', $com_row['school_code'])->update($com_row);

                    if($updated)
                    {
                        $audit_log = array('record_id' => $com_row['school_code'],
                            'table_name' => 'school_pupil_teacher_stats',
                            'sync_version' => $new_sync_version,
                            'last_version' => $current_version,
                            'current_version' => $new_sync_version
                        );

                        AuditLog::create($audit_log);
                        $modified_array[$com_row['school_code']] = $com_row;
                    }
                }
                else
                {
                    $not_modified_array[$com_row['school_code']] = $com_row;
                }
            }
            return response()->json(['success' => 'School pupil teachers imported successfully.']);
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
    public function importPupilDegreeStat()
    {
        set_time_limit(0);
        try
        {
            $degree_path = storage_path('app/files/exp_pers_amne_gr_skola_2015.xlsx');

            $inputFileType = 'Excel2007';
            /**  Create a new Reader of the type defined in $inputFileType  **/
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

            /**  Advise the Reader that we only want to load cell data  **/
            $objReader->setReadDataOnly(true);

            $sheetnames = array(0);
            $objReader->setLoadSheetsOnly($sheetnames);

            /**  Load only the rows and columns that match our filter to PHPExcel  **/
            $objPHPExcel = $objReader->load($degree_path);

            $objWorksheet = $objPHPExcel->getSheet(0);

            $modified_array = array();
            $not_modified_array = array();
            foreach ($objWorksheet->getRowIterator(9) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                // even if it is not set.
                // By default, only cells
                // that are set will be
                // iterated.

                foreach ($cellIterator as $k => $cell) {

                    if($k == 2)
                    {
                        $com_row['school_code'] = $cell->getValue();
                    }
                    elseif($k == 9)
                    {
                        $com_row['percent_teacher_pedagogical_degree'] = floatval($cell->getValue());
                    }
                }

                $AuditLog = AuditLog::where('table_name', 'school_pupil_teacher_stats')
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
                    $updated = SchoolPupilTeacherStat::where('school_code', $com_row['school_code'])->update($com_row);

                    if($updated)
                    {
                        $audit_log = array('record_id' => $com_row['school_code'],
                            'table_name' => 'school_pupil_teacher_stats',
                            'sync_version' => $new_sync_version,
                            'last_version' => $current_version,
                            'current_version' => $new_sync_version
                        );

                        AuditLog::create($audit_log);
                        $modified_array[$com_row['school_code']] = $com_row;
                    }
                }
                else
                {
                    $not_modified_array[$com_row['school_code']] = $com_row;
                }
            }
            return response()->json(['success' => 'School pupil teachers imported successfully.']);
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
