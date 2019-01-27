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

// Route::get('/', function () {
//     return view('welcome');
// });

/**
 * Index routes
 */
Route::get('/', 'IndexController@index');
Route::post('/', 'IndexController@upload');
Route::get('/delete/{file}', 'IndexController@delete');

/**
 * Report routes
 */
Route::get('/report', 'ReportController@report');


