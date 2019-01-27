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

/**
 * Index routes
 */
Route::get('/', 'IndexController@index');
Route::post('/', 'IndexController@upload');
Route::get('/delete/{file}', 'IndexController@delete');
Route::get('/clean', 'IndexController@cleanPath');

/**
 * Report routes
 */
Route::get('/data', 'ReportController@dataProcess');
Route::get('/report/{file}', 'ReportController@report');


