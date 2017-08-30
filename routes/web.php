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





Route::group(['middleware' => ['web']], function(){
    Route::get('/',          'PhotoController@index');

    Route::get('/how-it-works',   function () {return view('site.sections.about'); });
    Route::get('/terms',          function () {return view('site.sections.legals'); });
    Route::get('/privacy',        function () {return view('site.sections.privacy'); });

    Route::get('search',              'SearchController@search');
    Route::post('/new_vote',          'VoteController@store');
    Route::get('/color/{color}', ['as' => 'color', 'uses' => 'PhotoController@searchByColor']);
    Route::get('/photo/{id}', ['as' => 'id', 'uses' => 'PhotoController@show']);


    Route::get('/login', 'Auth\AuthController@login');
    Route::get('/logout', 'Auth\AuthController@logout');
    Route::post('/authenticate', 'Auth\AuthController@authenticate');
    Route::post('/register', 'Auth\AuthController@createUser');
});


Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'profile', 'namespace' => 'Profile'], function(){
    Route::get('/',          'UserController@profile');
    Route::get('/gallery/{id}',[ 'as' => 'id', 'uses' => 'UserController@gallery']);
//    Route::get('/',          'UserController@profile');
});


Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'api', 'namespace' => 'API'], function(){
    Route::post('/create/gallery', 'CreateController@createGallery');
    Route::post('/create/comment', 'CreateController@createComment');
    Route::post('/follow/user', 'CreateController@followUser');
//    Route::post('image', 'AdminController@uploadImage');
//    Route::post('images/delete/{id}', 'AdminController@deleteImage');
});

