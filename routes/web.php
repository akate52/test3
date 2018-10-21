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

Route::get('test', function () {
    return view('welcome');
});
//宣传页面
Route::any('activity0', 'StudentController@activity0');
//活动页面
Route::group(['middleware' => ['activity']], function () {
    Route::any('activity1', 'StudentController@activity1');
    Route::any('activity2', 'StudentController@activity2');
});

//表单
Route::group(['middleware' => ['web']], function () {
    Route::get('student/index', ['uses' => 'StudentController@index']);
    Route::any('student/create', ['uses' => 'StudentController@create']);
    Route::post('student/save', ['uses' => 'StudentController@save']);
    Route::any('student/update/{id}', ['uses' => 'StudentController@update']);
    Route::get('student/detail/{id}', ['uses' => 'StudentController@detail']);
    Route::get('student/delete/{id}', ['uses' => 'StudentController@delete']);
});

//缓存cache
Route::get('student/cache', ['uses' => 'StudentController@cache']);
Route::get('student/error', ['uses' => 'StudentController@error']);

//文件上传
Route::any('student/upload', ['uses' => 'StudentController@upload']);
//邮件发送
Route::any('student/sendEmail', ['uses' => 'StudentController@sendEmail']);
//队列
Route::any('student/queue', ['uses' => 'StudentController@queue']);


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
