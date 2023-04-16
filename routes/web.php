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

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

//Route::get('uni-to-ban/{uni}', 'RunTestScriptController@uniToBan');
//Route::get('test-sms-voice-2/{month}/{year}/{mobile_no}', 'RunTestScriptController@scriptWiseSmsCheck');
//Route::get('test-sms-voice','RunTestScriptController@index');
Route::get('manual-excel/{month}/{year}', 'RunTestScriptController@manual_excel');
//Route::get('test/pdf-view','TestController@index');



Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware(['auth']);

// useful php artisan command
Route::get('clear-all', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('clear-compiled');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    dd("Cleared");
});
Route::get('q-restart', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('queue:restart');
    dd('Ok');
});
Route::get('/', function () {
    return view(\Auth::check() ? 'home' : 'auth.login');
});

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::Routes();



Route::group(['middleware' => ['auth', 'auditTrails']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});


Route::resource('audit-trail', 'AuditTrailController')->middleware('permission:manage_audit_trail');

