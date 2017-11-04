<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

/*
  Verb	    URI	                    Action	Route Name
  GET	        /photos 	            index   photos.index
  GET	        /photos/create	        create	photos.create
  POST	    /photos	                store   photos.store
  GET	        /photos/{photo}	        show	photos.show
  GET	        /photos/{photo}/edit	edit	photos.edit
  PUT/PATCH	/photos/{photo}	        update	photos.update
  DELETE	    /photos/{photo}	        destroy	photos.destroy
 */

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','User\SkolvalController@index');

Route::group(['prefix' => 'import/'], function () {
//    Route::get('file', 'MetaController@importFile');
//    Route::get('download', 'MetaController@downloadFiles');
//    Route::get('communities', 'CommunityController@import');
//    Route::get('schools', 'SchoolController@import');
//    Route::get('pupil-stats', 'SchoolPupilTeacherStatController@import');
//    Route::get('national-results', 'NationalResultsDataController@import');
//    Route::get('upper-sec-data', 'QualifyUpperSecDataController@import');
//    Route::get('grade9-data', 'Grade9DataController@import');
//    Route::get('school-salsa-values', 'SchoolSalsaValueController@import');

    Route::group(['middleware' => ['auth', 'acl']],function () {
        Route::get('download', 'MetaController@downloadFiles');
        Route::get('communities', 'CommunityController@import');
        Route::get('schools', 'SchoolController@import');
        Route::get('pupil-stats', 'SchoolPupilTeacherStatController@import');
        Route::get('national-results', 'NationalResultsDataController@import');
        Route::get('upper-sec-data', 'QualifyUpperSecDataController@import');
        Route::get('grade9-data', 'Grade9DataController@import');
        Route::get('school-salsa-values', 'SchoolSalsaValueController@import');
    });
});

//admin routes
Route::group(['prefix' => 'admin'], function () {
    
    Route::get('select-community/{search}', 'Admin\SettingController@selectCommunity');
    Route::get('download', 'TrianglesController@download');    
    Route::get('get-one-client/{id}', 'Admin\ClientController@get_one_customer');
    Route::post('save-cuctomer-info', 'Admin\ClientController@save_one_customer');
    
    Route::get('get-comm-setting', 'Admin\SettingController@get_Community_Setting');
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/', 'Auth\LoginController@adminLoginForm');
        Route::get('activate/{id}/{code}', 'Admin\AdminController@adminActivationForm');
        Route::put('activate/{id}', ['as' => 'admin.activate', 'uses' => 'Admin\AdminController@activate']);        
        
    });
    Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'acl']], function () {
        Route::get('dashboard', 'AdminController@dashboard');
        Route::get('get-admin', 'AdminController@getAdmin');
        Route::resource('user', 'AdminController', ['as' => 'admin']);
        Route::get('get-client', 'ClientController@getClient');        
        Route::resource('client', 'ClientController', ['as' => 'admin']);
        Route::get('get-children', 'ChildrenController@getClient');
        Route::resource('children', 'ChildrenController', ['as' => 'admin']);
        Route::get('get-community', 'CommunityController@getCommunity');
        Route::resource('community', 'CommunityController', ['as' => 'admin']);
        Route::resource('colorcode', 'ColorcodeController', ['as' => 'admin']);
        Route::post('edit-colorcode/{id}', 'ColorcodeController@editColorCode', ['as' => 'admin']);
        Route::get('get-colorcode', 'ColorcodeController@getColorcode');
        Route::resource('triangles', 'TrianglesController', ['as' => 'admin']);
        Route::get('get-triangles', 'TrianglesController@getTriangles');
        Route::group(['prefix' => 'import'], function () {
            Route::get('community', 'CommunityController@import');
            Route::get('edit-file/{id}', 'CommunityController@editFile');
            Route::put('update-file/{id}', 'CommunityController@updateFile')->name('update-file');
        });
        Route::get('change-school-status/{id}/{status}', 'SchoolController@changeStatus');
        Route::get('get-school', 'SchoolController@getSchool');
        Route::resource('school', 'SchoolController', ['as' => 'admin']);
        Route::get('change-setting-status/{id}/{status}', 'SettingController@changeStatus');
        Route::get('get-setting', 'SettingController@getSetting');
        Route::post('update-setting', 'SettingController@updateSetting', ['as' => 'settings'])->name('update-settings');
        
        Route::resource('setting', 'SettingController', ['as' => 'admin']);
        Route::get('get-grade9data', 'Grade9DataController@getGrade9data');
        Route::resource('grade9data', 'Grade9DataController', ['as' => 'admin']);
        Route::get('get-national-result-data', 'NationalResultDataController@getNationalResultData');
        Route::resource('national-result-data', 'NationalResultDataController', ['as' => 'admin']);
        Route::get('get-school-salsa-value', 'SchoolSalsaValueController@getSchoolSalsaValues');
        Route::resource('school-salsa-value', 'SchoolSalsaValueController', ['as' => 'admin']);
        Route::get('get-qualify-upper-sec-data', 'QualifyUpperSecDataController@getQualifyUpperSecData');
        Route::resource('qualify-upper-sec-data', 'QualifyUpperSecDataController', ['as' => 'admin']);
        Route::get('get-school-pupil-teacher-stat', 'SchoolPupilTeacherStatController@getSchoolPupilTeacherStat');
        Route::resource('school-pupil-teacher-stat', 'SchoolPupilTeacherStatController', ['as' => 'admin']);
        Route::get('get-community-salsa-value', 'CommunitySalsaValueController@getCommunitySalsaValue');
        Route::resource('community-salsa-value', 'CommunitySalsaValueController', ['as' => 'admin']);
        Route::get('get-subject', 'SubjectController@getSubject');
        Route::resource('subject', 'SubjectController', ['as' => 'admin']);
        
    });
});

Route::get('test',function (){
    return App\School::where('id', 252)->withTrashed()->update(['lat'=> null]);
    return 'ok';
    //return $subscription = Auth::user()->subscription()->get();
    return App\Triangles::updateSubjectTriangles();
    return App\Triangles::updateSchoolTriangles();

    $current_year = App\Triangles::where('key', 'current_year')->select('value')->first();
    return $current_year->value;
    $current_year = App\Setting::where('key', 'current_year')->select('value')->first();
    return $current_year->value;

    return App\School::getNearBySchool(57.83, 13.01);

 //   return App\CommunitySalsaValue::where('community_code', 'LIKE', '0180%')->toSql();
    return App\Community::getNearByCommunity(57.83, 13.01, 1);

});

Route::get('cache',function (){
    return Artisan::call('config:cache');
});

//Route::get('info',function (){
//    echo phpinfo();
//});

Route::get('warning', function (){
   return App\Community::warning();
});
Route::get('update-lat-lng',function (){
    return App\School::updateLatLng();
//    App\Community::updateCommunityLatLng();
    return "done";
});

Route::get('/free-login', 'HomeController@free_login');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index');



/*
 * Routes for premium map
 */

Route::get('current-location-community-premium/{lat}/{lng}', 'User\MapController@currentLocationCommunity');

/*
 * Routes for selected municipality
 */
//Route::get('go-to-skolval/{community_name}', 'User\SkolvalController@callSkolval');
Route::get('skolval', 'User\SkolvalController@callSkolval');
//Route::get('skolval',function($community){
//    return view('skolval?community='.$community);
//});
Route::get('select-community/{search}', 'User\SkolvalController@selectCommunity');
Route::get('current-location-community/{lat}/{lng}', 'User\SkolvalController@currentLocationCommunity');
Route::get('get-community-schools/{community_title}/{community_code?}', 'User\SkolvalController@getCommunitySchools');
Route::get('get-premium-bar-schools', 'User\SchoolComparisonController@premium_bar');

/* Routes for Paid Users*/
Route::group(['namespace' => 'User', 'middleware' => ['auth', 'subscription']], function () {
    Route::post('school-comparison', 'SchoolComparisonController@comparison');
    Route::post('detail-comparison', 'SchoolComparisonController@detailComparison');
    Route::get('map', function(){
        return view('user.premium.map');
    });
});


Route::get('get-map-community-schools/{community_title}/{community_code?}', 'User\MapController@getCommunitySchools');


Route::post('get-schools-data', 'User\MapController@schoolsData');

Route::get('get-single-schools/{school_code}', 'User\MapController@singleSchoolsData');
/*
 * Routes for Children info
 */

Route::post('save-children-info', 'ContactController@add_children_data');
Route::get('account-info', 'ContactController@account_data');
//Route::get('account-info', 'ContactController@account_data');
Route::get('about',function(){
   return view('user.about');
});
Route::get('premium', function(){
    return view('user.premium');
});
/*
 * Routes for Account
 */


/*  
 * Routes for contact
 */

Route::get('contact', 'ContactController@index');
Route::post('contact', 'ContactController@send_feedback');

/*
 * Routes for subscription
 */
Route::get('account', function () {
    return view('user.account');
});

Route::get('questions', function(){
    return view('user.questions');
});

Route::get('subscribe', function () {
//        return view('subscribe');
    return view('user.subscription.subscribe');
});
Route::post('order-post', ['as' => 'order-post', 'uses' => 'SubscriptionController@create_subscription']);
Route::get('update-card', function () {
    return view('user.subscription.update_card');
});
Route::post('update-credit-card', ['as' => 'update-credit-card', 'uses' => 'SubscriptionController@update_credit_card']);
/*
 * Routes for handling events of stripe*
 */
//Route::post('stripe/webhook','WebhookController@handleWebhook');
Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

