<?php

Route::controllers([
    'auth'     => 'AuthController',
    'password' => 'PasswordController'
]);

//locale
Route::get('language/{locale}',
    array(
        'as' => 'language.select',
        'uses' => 'LocaleController@changeLocale'
    )
);

Route::resource('track', 'TrackController');

Route::resource('category', 'CategoryController');

Route::get('category/{category}/track','CategoryController@getTrack');
Route::get('category/{category}/article','CategoryController@getArticle');

Route::resource('album', 'AlbumController');

Route::resource('article', 'BlogController');

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
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['admin']], function () {

    Route::resource('category', 'CategoryController');

    Route::resource('album', 'AlbumController');

    Route::resource('track', 'TrackController');

    Route::resource('photo', 'PhotoController');

    Route::resource('blog', 'BlogController');

    Route::resource('user', 'UserController');

    Route::resource('author', 'AuthorController');

    Route::get('/', 'HomeController@index');

});

Route::get('test', function () {

//    $date = '09/14/2014';
//    dd(Carbon\Carbon::parse($date));
//    dd(ini_get('upload_max_filesize'));
//    echo phpinfo();
//    $trackUploader = App::make('\App\Src\Track\TrackCrawler');
//
//    $trackUploader->syncTracks();
//
//    dd('done');
    $user = new App\Src\User\User();
    $user->email = 'pnabdurahman@gmail.com';
    $user->password = bcrypt('bismillah123');
    $user->isAdmin = 1;
    $user->name = 'AbduRahman';
    $user->active = 1;
    $user->save();
});