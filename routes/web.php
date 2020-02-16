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

Route::get('/', function () {
    echo date("Y-m-d H:i:s");
    return view('welcome');
});

//phpinfo
Route::get('/phpinfo', function () {
    phpinfo();
});

Route::prefix('/curl')->group(function(){
    Route::get('/post','TestController@curlpost');  //curl测试 form-data
    Route::get('/post1','TestController@curlpost1');  //curl测试 form-urleccoded
    Route::get('/post2','TestController@curlpost2');  //curl测试 raw

    Route::get('/upload','TestController@upload');  //访问接口上传文件
});

Route::prefix('/guzzle')->group(function(){
    Route::get('/get','TestController@guzzle');  //guzzle get请求
    Route::get('/post','TestController@guzzle1');  //guzzle post请求
    Route::get('/upload','TestController@guzzleUpload');  //guzzle的文件上传
});
