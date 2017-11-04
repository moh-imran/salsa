<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Community;
use App\ExcelImportMeta;
use phpDocumentor\Reflection\Types\Object_;
use Session;
use App\School;
use App\Setting;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $communities = Community::select()->paginate(10);
        return view('admin.community.index', compact('communities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editFile($id)
    {
        $file = $this->getFileInfo('', $id);

        return view('admin.import.edit', compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFile($id, Request $request)
    {
        $data = $request->all();
        $result = ExcelImportMeta::find($id)->update($data);
        Session::flash('success', 'File information successfully updated!');
        return redirect('admin/import/community');
    }

    public function import(){
        $files = array();
        //Community and schools data files
        $files['schools'] = $this->getFileInfo('school');

        //Pupil teachers data files
        $files['pupil_teachers']['school_counts'] = $this->getFileInfo('school_counts');
        $files['pupil_teachers']['school_degrees'] = $this->getFileInfo('school_degrees');
        //Use schools file for pupil teachers school stats

        //National results data files
        $files['national_results']['so_results'] = $this->getFileInfo('so_results');
        $files['national_results']['no_results'] = $this->getFileInfo('no_results');
        $files['national_results']['ap9_results'] = $this->getFileInfo('ap9_results');

        //Qualified upper secondary data files
        $files['qualified_upper_sec'] = $this->getFileInfo('qualified_upper_sec');

        //Grade9 data files
        $files['grade9_file'] = $this->getFileInfo('grades');

        //Schools and community salsa values data files
        $files['salsa_values'] = $this->getFileInfo('salsa');

        $current_year = Setting::where('key', 'current_year')->select('value')->first();
        $CURRENT_YEAR = $current_year->value;
        if(empty($CURRENT_YEAR))
            $CURRENT_YEAR = date('Y') - 1;

        return view('admin.community.import', compact("files", "CURRENT_YEAR"));
    }

    public function getFileInfo($case, $id = 0)
    {
        $salsa_files = '';
        switch($case)
        {
            case 'community':
            case 'school':
                $file_info = ExcelImportMeta::where('key', SCHOOLS_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                break;

            case 'school_counts':
                $file_info = ExcelImportMeta::where('key', 'exp_personal_gr_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                break;

            case 'school_degrees':
                $file_info = ExcelImportMeta::where('key', 'exp_pers_amne_gr_skola_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                break;

            case 'so_results':
                $file_info = ExcelImportMeta::where('key', 'exp_ap9_so_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                break;

            case 'no_results':
                $file_info = ExcelImportMeta::where('key', 'exp_ap9_no_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                break;

            case 'ap9_results':
                $file_info = ExcelImportMeta::where('key', 'exp_ap9_masven_gr_')->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                break;

            case 'qualified_upper_sec':
                $file_info = ExcelImportMeta::where('key', QUALIFIED_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                break;

            case 'grades':
                $file_info = ExcelImportMeta::where('key', GRADES_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                break;

            case 'salsa':
                $files = ExcelImportMeta::where('key', SALSA_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(3)->get();
                foreach($files as $file)
                {
                    $result = $this->fetchNameAndPath($file->relative_path_on_server);
                    $file->relative_path_on_server = $result['file_path'];
                    $file->key = $result['file_name'];
                    $salsa_files[] = $file;
                }
                break;

            default:
                //$file_info = ExcelImportMeta::where('key', SCHOOLS_LABEL)->whereNotIn('file_size', [0])->orderBy('id','desc')->take(1)->first();
                $file_info = ExcelImportMeta::find($id);
                break;
        }

        if(!empty($salsa_files))
        {
            return $salsa_files;
        }

        if(!empty($file_info))
        {
            $result = $this->fetchNameAndPath($file_info->relative_path_on_server);
            $file_info->relative_path_on_server = $result['file_path'];
            $file_info->key = $result['file_name'];

            $file_info->status = ($file_info->status == 2) ? 'Processed':'Pending';
        }
        else
        {
            $file_info = new Object_();

            $file_info->relative_path_on_server = '';
            $file_info->key = '';
            $file_info->status = '';
            $file_info->download_url = '';
        }
//dd($file_info);
        return $file_info;
    }

    public function fetchNameAndPath($pull_path)
    {
        $storage_path = explode("/", $pull_path);
        $file_name = last($storage_path);
        array_pop($storage_path );
        $file_path = implode('/', $storage_path);
        $result['file_path'] = $file_path;
        $result['file_name'] = $file_name;
        return $result;
    }

    public function getCommunity(Request $request){
        $search = $request->get('search');
        $orderBy = $request->get('orderBy');
        $order = explode(',', $orderBy);
        $communities = Community::select();
        if(!empty($search)){
            $communities->where('code', 'like', "%".$search."%")
                ->orWhere('title', 'like', "%".$search."%");
        }
        if(!empty($orderBy)){
            $communities->orderBy($order[0], ($order[1])? $order[1]: 'asc');
        }else{
            $communities->orderBy('title', 'asc');
        }
        return $communities = $communities->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.community.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'code' => 'required|string|unique:communities'
        ]);
        $community = $request->all();

        Community::create($community);
        return redirect('admin/community');
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
        $community = Community::find($id);
        return view('admin.community.edit', compact('community'));
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
        $community = $request->all();
        $this->validate($request, [
            'title' => 'required|string'
        ]);
        $new_community = Community::find($id);
        $new_community->title = $community['title'];
        $new_community->save();
//      cahnge in community title in all related schools
        School::where('community_code', $new_community->code)->update(['community_title' => $community['title']]);

        return redirect('admin/community');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Community::find($id)->delete();
        return "ok";
    }
}
