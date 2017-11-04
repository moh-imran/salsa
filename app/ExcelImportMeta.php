<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ExcelImportMeta extends Model
{

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'excel_import_metas';
    //status 1 means pending, 2 means processed, 3 means identical to previous version
    protected $fillable = [
        'title_key',
        'key',
        'download_url',
        'relative_path_on_server',
        'from_year',
        'to_year',
        'description',
        'first_data_row',
        'file_size',
        'checksum_of_last_file',
        'version_no',
        'status',
        'created_by',
        'updated_by'
    ];

    public static function updateProcessed($id)
    {
        ExcelImportMeta::where('id', $id)->update(['status' => '2']);
    }

    public static function saveFile($url, $file)
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

}
