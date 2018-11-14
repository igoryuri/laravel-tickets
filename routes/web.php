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


//
//Route::get('/pusher', function() {
//    event(new App\Events\RefreshPusherEvent('Hi there Pusher!'));
//    return "Event has been sent!";
//});

Route::group(['prefix' => 'bioclin'], function () {
    Auth::routes();

    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/readed', function () {
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        return back();
    })->middleware('auth')->name('monitorings.readed');
});



Route::group(['middleware' => ['auth', 'check.department'], 'prefix' => 'bioclin'], function () {

//    Route::get('/monitorings/{monitoring}/show', 'MonitoringController@monitoring')->name('monitorings.monitoring');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/closed', 'HomeController@closed')->name('dashboard.closed');
    Route::get('/monitoring/{monitoring}', 'MonitoringController@showPage')->name('monitorings.showPage');
    Route::get('/ajaxdata', 'HomeController@getAjaxData')->name('getajaxData');
    Route::get('/timeline/{id}', 'TimelineController@show')->name('timeline.show');
    Route::resource('users', 'UserController', ['only' => ['index', 'edit', 'update', 'destroy']]);
    Route::resource('tickets', 'TicketController');
    Route::resource('departments', 'DepartmentController');
    Route::resource('categories', 'CategoryController');
    Route::get('/ajax-category', 'CategoryController@getCategory')->name('categories.getCategory');
    Route::resource('assigns', 'AssignController', ['only' => ['store', 'update']]);
    Route::resource('solutions', 'SolutionController', ['only' => ['store', 'show', 'update']]);
    Route::resource('monitorings', 'MonitoringController', ['only' => ['create', 'store', 'show']]);
    Route::resource('permissions', 'PermissionController');
    Route::resource('routes', 'RouteController');
});
