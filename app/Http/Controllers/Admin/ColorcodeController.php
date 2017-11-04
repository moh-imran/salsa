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

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ColorCode;
use Session;
use Auth;


class ColorcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$communities = ColorCode::select()->paginate(100);
        return view('admin.colorcodes.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getColorcode()
    {
        return $communities = ColorCode::select()->paginate(100);
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
        $colorcode = ColorCode::find($id);
        return view('admin.colorcodes.edit', compact('colorcode'));
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
        //return $request;

        //$code =  Community::find($id)->code;
        $colorcode = $request->all();

        $colorcode['status'] = (isset($colorcode['status']))? '1': '0';
        $colorcode['is_free'] = (isset($colorcode['is_free']))? '1': '0';

        $this->validate($request, [
            //'key' => 'required|string',
            'much_higher_when_greater_than' => 'numeric',
            'above_when_greater_than' => 'numeric',
            //'average_when_greater_than' => 'numeric',
            'below_when_less_than' => 'numeric',
            'much_below_when_less_than' => 'numeric',
            //'status' => 'required|string',
            //'is_free' => 'required|string',
            //'label' => 'required|string',
            //'created_by' => 'required|string',
            //'updated_by' => 'required|string'
        ]);

        ColorCode::where('id', $id)->update([
            //'key' => $colorcode['key'],
            //'label' => $colorcode['label'],
            'much_higher_when_greater_than' => $colorcode['much_higher_when_greater_than'],
            'above_when_greater_than' => $colorcode['above_when_greater_than'],
            //'average_when_greater_than' => $colorcode['average_when_greater_than'],
            'below_when_less_than' => $colorcode['below_when_less_than'],
            'much_below_when_less_than' => $colorcode['much_below_when_less_than'],
            'status' => $colorcode['status'],
            'is_free' => $colorcode['is_free'],
            'is_reverse' => $colorcode['is_reverse'],
            'updated_by' => Auth::user()->id,
            //'created_by' => $colorcode['created_by'],
        ]);
        Session::flash('success', 'Color code successfully updated!');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editColorCode(Request $request, $id)
    {
        //$code =  Community::find($id)->code;
        $colorcode = $request->all();

        $colorcode['status'] = (isset($colorcode['status']) && $colorcode['status'])? '1': '0';
        $colorcode['is_free'] = (isset($colorcode['is_free']) && $colorcode['is_free'])? '1': '0';
        $colorcode['is_reverse'] = (isset($colorcode['is_reverse']) && $colorcode['is_reverse'])? '1': '0';

        $this->validate($request, [
            //'key' => 'required|string',
            'much_higher_when_greater_than' => 'numeric',
            'above_when_greater_than' => 'numeric',
            //'average_when_greater_than' => 'numeric',
            'below_when_less_than' => 'numeric',
            'much_below_when_less_than' => 'numeric',
            //'status' => 'required|string',
            //'is_free' => 'required|string',
            //'label' => 'required|string',
            //'created_by' => 'required|string',
            //'updated_by' => 'required|string'
        ]);

        ColorCode::where('id', $id)->update([
            //'key' => $colorcode['key'],
            //'label' => $colorcode['label'],
            'much_higher_when_greater_than' => $colorcode['much_higher_when_greater_than'],
            'above_when_greater_than' => $colorcode['above_when_greater_than'],
            //'average_when_greater_than' => $colorcode['average_when_greater_than'],
            'below_when_less_than' => $colorcode['below_when_less_than'],
            'much_below_when_less_than' => $colorcode['much_below_when_less_than'],
            'status' => $colorcode['status'],
            'is_free' => $colorcode['is_free'],
            'is_reverse' => $colorcode['is_reverse'],
            'updated_by' => Auth::user()->id,
            //'created_by' => $colorcode['created_by'],
        ]);
        Session::flash('success', 'Color code successfully updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ColorCode::find($id)->delete();
        return "ok";
    }
}
