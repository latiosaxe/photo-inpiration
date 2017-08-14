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

//Route::get('/', function () {
//    return view('site.sections.home');
//});

Route::get('/',          'PhotoController@index');


Route::get('/how-it-works',   function () {return view('site.sections.about'); });
Route::get('/terms',   function () {return view('site.sections.legals'); });
Route::get('/privacy', function () {return view('site.sections.privacy'); });

Route::get('search',              'SearchController@search');

Route::post('/new_vote',          'VoteController@store');

Route::get('/color/{color}', ['as' => 'color', 'uses' => 'PhotoController@searchByColor']);
