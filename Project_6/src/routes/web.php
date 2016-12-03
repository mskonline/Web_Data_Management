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
//Route::get('foo',function(){return '<h1>foo';});
Route::get('/', 'Page1@index');
Route::any('customer', 'Page1@index');
Route::any('page1', 'Page1@index');
Route::any('page2', 'Page2@index');
Route::any('page3', 'Page3@index');
Route::any('page4', 'Page4@index');