<?php

/**
 * https://github.com/pantlavanya/export-to-excel-using-phpoffice-phpexcel-in-laravel-5
 * export-to-excel-using-phpoffice-phpexcel-in-laravel-5
 *
 * Open the file "/vendor/composer/autoload_namespaces.php". Paste the below line in the file.
 *
 * Include PHPEXCEL Library with Laravel 5
 * 'PHPExcel' => array($vendorDir . '/phpoffice/phpexcel/Classes'),
 * Now you can use PHPEXCEL library in your controllers or middleware or library.
 * use PHPExcel;
 * use PHPExcel_IOFactory;
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use PHPExcel;
use PHPExcel_IOFactory;
use App\Community;
use App\AuditLog;
use App\ExcelImportMeta;
use Auth;


class CommunityController extends Controller
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
        $audit_log_records = array();
        $count = 0;
        try
        {
            //return 'import';
            $existing_file = ExcelImportMeta::where('key', SCHOOLS_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->get();
            if($existing_file->count())
            {
                $existing_file = $existing_file[0];
            }

            //Download latest files
            if ($existing_file) {
                ExcelImportMeta::saveFile($existing_file->download_url, $existing_file->relative_path_on_server);
            }

            $path = $existing_file->relative_path_on_server;
            $objWorksheet = $this->getWorksheets($path);

            foreach ($objWorksheet->getRowIterator($existing_file->first_data_row) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                // even if it is not set. By default, only cells that are set will be iterated.
                $com_row = array();

                foreach ($cellIterator as $k => $cell) {
                    if($k == 4)
                    {
                        $com_row['code'] = $cell->getValue();
                    }
                    elseif($k == 5)
                    {
                        $com_row['title'] = $cell->getValue();
                    }
                }

                $AuditLog = AuditLog::where('table_name', 'communities')
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
                    $com_row['created_by'] = Auth::user()->id;
                    $com_row['updated_by'] = Auth::user()->id;
                    Community::updateOrCreate(['code'=> $com_row['code']], $com_row);
                    unset($com_row['created_by']);
                    unset($com_row['updated_by']);

                    $audit_log = array('record_id' => $com_row['code'],
                        'table_name' => 'communities',
                        'sync_version' => $new_sync_version,
                        'last_version' => $current_version,
                        'current_version' => $new_sync_version
                    );

                    //AuditLog::create($audit_log);
                    $audit_log_records[$count] = $audit_log;
                    $count++;
                }
            }
            if(!empty($audit_log_records))
            {
                AuditLog::insert($audit_log_records);
            }

            ExcelImportMeta::updateProcessed($existing_file->id);

            return response()->json(['success' => 'Communities imported successfully.']);
        }
        catch(\Exception $e)
        {
            if(!empty($audit_log_records))
            {
                AuditLog::insert($audit_log_records);
            }
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
