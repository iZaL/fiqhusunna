<?php

Route::controllers([
    'auth'     => 'AuthController',
    'password' => 'PasswordController'
]);


Route::resource('track', 'TrackController');

Route::resource('category', 'CategoryController');

Route::resource('album', 'AlbumController');

Route::resource('blog', 'BlogController');

Route::get('locale/{lang}', ['as' => 'locale.select', 'uses' => 'LocaleController@setLocale']);

Route::get('profile', 'UserController@profile');

Route::get('track/download/{id}', 'TrackController@downloadTrack');

Route::get('about', 'PageController@getAbout');

Route::get('contact', 'PageController@getContact');

Route::post('contact', 'PageController@postContact');

Route::get('home', 'HomeController@index');

Route::get('/', 'HomeController@index');


/*********************************************************************************************************
 * Admin Routes
 ********************************************************************************************************/
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::resource('category', 'CategoryController');

    Route::resource('album', 'AlbumController');

    Route::resource('track', 'TrackController');

    Route::resource('photo', 'PhotoController');

    Route::resource('blog', 'BlogController');

    Route::get('/', 'HomeController@index');

//    get('track/category/create', 'TrackController@createCategoryTrack');
//
//    get('track/album/create', 'TrackController@createAlbumTrack');
//
//    post('track/upload', 'TrackController@uploadTrack');

});

Route::get('test', function () {

    echo exec('whoami');
//
//    $trackUploader = App::make('\App\Src\Track\TrackCrawler');
//
//    $trackUploader->syncTracks();
//
//    dd('done');

});