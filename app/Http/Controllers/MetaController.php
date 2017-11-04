<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExcelImportMeta;
use App\Setting;

class MetaController extends Controller
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

    public function downloadFiles()
    {
        try {
            $current_year = Setting::where('key', 'current_year')->select('value')->first();
            $CURRENT_YEAR = $current_year->value;
            if(empty($CURRENT_YEAR))
                $CURRENT_YEAR = date('Y') - 1;

            $files = $this->downloadSchoolsFiles($CURRENT_YEAR);
            $files = $this->downloadSalsaFiles($CURRENT_YEAR);
            $files = $this->downloadQualifiedFiles($CURRENT_YEAR);
            $files = $this->downloadGradesFiles($CURRENT_YEAR);
            $files = $this->downloadNationalResultFiles($CURRENT_YEAR);
            $files = $this->downloadTeachersFiles($CURRENT_YEAR);

            //echo "All files downloaded successfully";
            return "All files downloaded successfully";
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * @return bool|string
     */
    public function downloadSchoolsFiles($year)
    {
        try {
            //$year = date('Y');

            $existing_salsa_file = ExcelImportMeta::where('title_key', SCHOOLS_LABEL)->orderBy('id','desc')->take(1)->get();
            if(!$existing_salsa_file->isEmpty())
            {
                $existing_salsa_file = $existing_salsa_file[0];
            }
            $storage_dir = '../storage/app/files/'. SCHOOLS_DIR_NAME .'/';
            if (!file_exists($storage_dir)) {
                mkdir($storage_dir, 0777, true);
            }
            $url = 'http://www.skolverket.se/polopoly_fs/1.215072!/Skolenhetsregistret.xls';
            //Right now we are using static value 5 for pnExportID, Its means download qualified upper secondary data file
            $file_url = Setting::where('group', 'download')->where('key', 'schools')->take(1)->get();
            if($file_url->count())
            {
                $file_url = $file_url[0];
                $url = $file_url->value;
            }

            $file = "Skolenhetsregistret_".$year."_". time() .".xls";
            $file_path = $storage_dir .$file;
            $this->saveFile($url, $file_path);

            $data_array = ['title_key' => SCHOOLS_LABEL,
                'key' => SCHOOLS_LABEL,
                'download_url' => $url,
                'relative_path_on_server' => $file_path,
                'from_year' => $year,
                'to_year' => $year,
                'description' => SCHOOLS_LABEL .' import file',
                'first_data_row' => '2',
                'file_size' => filesize($file_path) / 1024, //file size calculation is in KBs
                'checksum_of_last_file' => md5_file($file_path),
                'version_no' => '1',
                'status' => '1'];
            //status 1 means pending, 2 means processed, 3 means identical to previous version

            if($existing_salsa_file->count())
            {
                $data_array['version_no'] = $existing_salsa_file->version_no + 1;
            }
            ExcelImportMeta::create($data_array);
            return TRUE;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * @return bool|string
     * It will collect last three years data files
     */
    public function downloadSalsaFiles($year)
    {
        try {
            //We cannot download current year's data file (Data updates on christmas)
            $current_year = $year - 1;

            $existing_salsa_file = ExcelImportMeta::where('title_key', SALSA_LABEL)->orderBy('id','desc')->take(1)->get();

            if(!$existing_salsa_file->isEmpty())
            {
                $existing_salsa_file = $existing_salsa_file[0];
            }
            $storage_dir = '../storage/app/files/'. SALSA_DIR_NAME .'/';
            if (!file_exists($storage_dir)) {
                mkdir($storage_dir, 0777, true);
            }

            for($i=2; $i>=0; $i--) {
                $year = $current_year;
                $current_year--;
                //Right now we are using static value 95 for pnExportID, Its means download salsa data file
                $url = 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=95&psVerksamhetsar='.$year.'&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=';

                $file = "exp_salsa_".$year."_". time() .".xlsx";
                $file_path = $storage_dir .$file;
                $this->saveFile($url, $file_path);

                $data_array = ['title_key' => SALSA_LABEL,
                    'key' => SALSA_LABEL,
                    'download_url' => $url,
                    'relative_path_on_server' => $file_path,
                    'from_year' => $year,
                    'to_year' => $year,
                    'description' => SALSA_LABEL . ' import file',
                    'first_data_row' => '8',
                    'file_size' => filesize($file_path) / 1024, //file size calculation is in KBs
                    'checksum_of_last_file' => md5_file($file_path),
                    'version_no' => '1',
                    'status' => '1'];
                //status 1 means pending, 2 means processed, 3 means identical to previous version

                if($existing_salsa_file->count())
                {
                    $data_array['version_no'] = $existing_salsa_file->version_no + 1;
                }
                ExcelImportMeta::create($data_array);
            }
            return TRUE;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * @return bool|string
     * If we are to use three year averages this report has to be generated for 2015/16, 2014/15 and 2013/14.
     * 2015/16 means we need to use 2016 for psVerksamhetsar parameter
     */
    public function downloadQualifiedFiles($year)
    {
        try {
            //$year = date('Y');

            $existing_salsa_file = ExcelImportMeta::where('title_key', QUALIFIED_LABEL)->orderBy('id','desc')->take(1)->get();
            if(!$existing_salsa_file->isEmpty())
            {
                $existing_salsa_file = $existing_salsa_file[0];
            }
            $storage_dir = '../storage/app/files/'. QUALIFIED_DIR_NAME .'/';
            if (!file_exists($storage_dir)) {
                mkdir($storage_dir, 0777, true);
            }
            //Right now we are using static value 5 for pnExportID, Its means download qualified upper secondary data file
            $url = 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=5&psVerksamhetsar='. $year .'&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=';

            $file = "exp_behorig_gy_".$year."_". time() .".xlsx";
            $file_path = $storage_dir .$file;
            $this->saveFile($url, $file_path);

            $data_array = ['title_key' => QUALIFIED_LABEL,
                'key' => QUALIFIED_LABEL,
                'download_url' => $url,
                'relative_path_on_server' => $file_path,
                'from_year' => $year,
                'to_year' => $year,
                'description' => QUALIFIED_LABEL .' import file',
                'first_data_row' => '9',
                'file_size' => filesize($file_path) / 1024, //file size calculation is in KBs
                'checksum_of_last_file' => md5_file($file_path),
                'version_no' => '1',
                'status' => '1'];
            //status 1 means pending, 2 means processed, 3 means identical to previous version

            if($existing_salsa_file->count())
            {
                $data_array['version_no'] = $existing_salsa_file->version_no + 1;
            }
            ExcelImportMeta::create($data_array);
            return TRUE;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * @return bool|string
     * If we are to use three year averages this report has to be generated for 2015/16, 2014/15 and 2013/14.
     * 2015/16 means we need to use 2016 for psVerksamhetsar parameter
     */
    public function downloadGradesFiles($year)
    {
        try {
            //$year = date('Y');

            $existing_salsa_file = ExcelImportMeta::where('title_key', GRADES_LABEL)->orderBy('id','desc')->take(1)->get();
            if(!$existing_salsa_file->isEmpty())
            {
                $existing_salsa_file = $existing_salsa_file[0];
            }
            $storage_dir = '../storage/app/files/'. GRADES_DIR_NAME .'/';
            if (!file_exists($storage_dir)) {
                mkdir($storage_dir, 0777, true);
            }
            //Right now we are using static value 93 for pnExportID, Its means download grades per subject data file
            $url = 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=93&psVerksamhetsar='. $year .'&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=';

            $file = "exp_slutbetyg_amne_skola_".$year."_". time() .".xlsx";
            $file_path = $storage_dir .$file;
            $this->saveFile($url, $file_path);

            $data_array = ['title_key' => GRADES_LABEL,
                'key' => GRADES_LABEL,
                'download_url' => $url,
                'relative_path_on_server' => $file_path,
                'from_year' => $year,
                'to_year' => $year,
                'description' => GRADES_LABEL .' import file',
                'first_data_row' => '11',
                'file_size' => filesize($file_path) / 1024, //file size calculation is in KBs
                'checksum_of_last_file' => md5_file($file_path),
                'version_no' => '1',
                'status' => '1'];
            //status 1 means pending, 2 means processed, 3 means identical to previous version

            if($existing_salsa_file->count())
            {
                $data_array['version_no'] = $existing_salsa_file->version_no + 1;
            }
            ExcelImportMeta::create($data_array);
            return TRUE;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * @return bool|string
     *
     * pnExportID=75 N.B. This selection generates national test results for Biology, Physics and Chemistry.
     * pnExportID=76 By selecting the second choice in the Statistikområde field the results in Geography, History, Religion and Social sciences are retrieved.
     * pnExportID=73 By selecting the third choice in the Statistikområde field the results in sub tests in English, Mathematics, and Swedish/Swedish as a second language are retrieved.
     * pnExportID=75 By selecting the fourth choice in the Statistikområde field the total results in English, Mathematics, and Swedish/Swedish as a second language are retrieved.
     */
    public function downloadNationalResultFiles($year)
    {
        try {
            //, '73'=>'exp_ap9_' Right now we are ignoring the results in sub tests in English, Mathematics, and Swedish/Swedish
            $test_array = ['75'=>'exp_ap9_no_', '76'=>'exp_ap9_so_', '77'=>'exp_ap9_masven_gr_'];

            $existing_salsa_file = ExcelImportMeta::where('title_key', NATIONAL_LABEL)->orderBy('id','desc')->take(1)->get();

            if(!$existing_salsa_file->isEmpty())
            {
                $existing_salsa_file = $existing_salsa_file[0];
            }
            $storage_dir = '../storage/app/files/'. NATIONAL_DIR_NAME .'/';
            if (!file_exists($storage_dir)) {
                mkdir($storage_dir, 0777, true);
            }

            //$year = date("Y");
            $start_from = $year - 3;
            foreach($test_array as $id => $title_key) {

                $url = 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID='. $id .'&psVerksamhetsar='.$year.'&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=';
                //When we download this file directly from browser it's name start from last three years
                //that's why we are concatenating previous third year in the name
                $file = $title_key. $start_from . "_" . $year."_". time() .".xlsx";
                $file_path = $storage_dir .$file;
                $this->saveFile($url, $file_path);

                $data_array = ['title_key' => NATIONAL_LABEL,
                    'key' => $title_key,
                    'download_url' => $url,
                    'relative_path_on_server' => $file_path,
                    'from_year' => $year,
                    'to_year' => $year,
                    'description' => NATIONAL_LABEL . ' import file',
                    'first_data_row' => '9',
                    'file_size' => filesize($file_path) / 1024, //file size calculation is in KBs
                    'checksum_of_last_file' => md5_file($file_path),
                    'version_no' => '1',
                    'status' => '1'];
                //status 1 means pending, 2 means processed, 3 means identical to previous version

                if($existing_salsa_file->count())
                {
                    $data_array['version_no'] = $existing_salsa_file->version_no + 1;
                }
                ExcelImportMeta::create($data_array);
            }
            return TRUE;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * @return bool|string
     *
     * pnExportID=16 N.B. This selection generates staff statistics.
     * pnExportID=101 By selecting the second choice in the Statistikområde field staff statistics with teacher licences and qualifications for at least one subject is retrieved.
     * pnExportID=102 By selecting the third choice in the Statistikområde field staff statistics with teacher licences and qualifications per subject is retrieved.
     * Selection 2 and 3 alerts a ”as per date” field. If there are several dates to choose from we should obviously always choose the newest date.
     */
    public function downloadTeachersFiles($year)
    {
        try {
            $test_array = ['16'=>'exp_personal_gr_', '101'=>'exp_pers_amne_gr_skola_', '102'=>'exp_pers_amne_gr_skola_amne_'];

            $existing_salsa_file = ExcelImportMeta::where('title_key', TEACHERS_LABEL)->orderBy('id','desc')->take(1)->get();

            if(!$existing_salsa_file->isEmpty())
            {
                $existing_salsa_file = $existing_salsa_file[0];
            }
            $storage_dir = '../storage/app/files/'. TEACHERS_DIR_NAME .'/';
            if (!file_exists($storage_dir)) {
                mkdir($storage_dir, 0777, true);
            }

            //data is generating up till last year (max)
            $year = $year - 1;
            foreach($test_array as $id => $title_key) {

                $psOmgang = '1';
                $first_data_row = 10;
                if($id == 16)
                {
                    $psOmgang = '';
                    $first_data_row = 7;
                }
                elseif($id == 101)
                {
                    $first_data_row = 9;
                }

                $url = 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID='. $id .'&psVerksamhetsar='.$year.'&psOmgang='. $psOmgang .'&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=';
                $file = $title_key.$year."_". time() .".xlsx";
                $file_path = $storage_dir .$file;
                $this->saveFile($url, $file_path);

                $data_array = ['title_key' => TEACHERS_LABEL,
                    'key' => $title_key,
                    'download_url' => $url,
                    'relative_path_on_server' => $file_path,
                    'from_year' => $year,
                    'to_year' => $year,
                    'description' => TEACHERS_LABEL . ' import file',
                    'first_data_row' => $first_data_row,
                    'file_size' => filesize($file_path) / 1024, //file size calculation is in KBs
                    'checksum_of_last_file' => md5_file($file_path),
                    'version_no' => '1',
                    'status' => '1'];
                //status 1 means pending, 2 means processed, 3 means identical to previous version

                if($existing_salsa_file->count())
                {
                    $data_array['version_no'] = $existing_salsa_file->version_no + 1;
                }
                ExcelImportMeta::create($data_array);
            }
            return TRUE;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function saveFile($url, $file)
    {
        set_time_limit(0);
        //This is the file where we save the    information
        $fp = fopen ($file, 'w+');
        //Here is the file we are downloading, replace spaces with %20
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // get curl response
        $result = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        //wait for 1 second to calculate proper file size
        //sleep(1);

        return $result;
    }

    public function importFile()
    {
        try {
            $file1 = storage_path('app/files/file1.txt');
            $file2 = storage_path('app/files/file2.txt');

            $md5_1 = md5_file($file1);
            $md5_2 = md5_file($file2);

            if($md5_1 !== $md5_2)
            {
                return 'files not identical';
            }
            else
            {
                return 'files identical';
            }

            if ($this->files_identical($file1, $file2))
                return 'files identical';
            else
                return 'files not identical';
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //pass two file names
    //returns TRUE if files are the same, FALSE otherwise
    function files_identical($fn1, $fn2) {
        if(filetype($fn1) !== filetype($fn2))
            return FALSE;

        if(filesize($fn1) !== filesize($fn2))
            return FALSE;

        if(!$fp1 = fopen($fn1, 'rb'))
            return FALSE;

        if(!$fp2 = fopen($fn2, 'rb')) {
            fclose($fp1);
            return FALSE;
        }

        $same = TRUE;
        while (!feof($fp1) and !feof($fp2))
            if(fread($fp1, 1) !== fread($fp2, 1)) {
                $same = FALSE;
                break;
            }

        if(feof($fp1) !== feof($fp2))
            $same = FALSE;

        fclose($fp1);
        fclose($fp2);

        return $same;
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
