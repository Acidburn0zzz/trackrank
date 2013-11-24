<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//API: search
Route::get('/query/{query_string}', 'QueryController@getSearch');

//API: get artist by MBID
Route::get('/query/artist/{query_string}', 'QueryController@getArtistById');

//API: get artists releases by MBID from LastFM
Route::get('query/artist_releases/{query_string}', 'QueryController@getReleasesByArtistId');

//API: get artists releases by MBID from MusicBrainz
Route::get('query/artist_releases_mb/{query_string}', 'QueryController@getReleasesByArtistMBID');

//API: get release data from LastFM by MBID
Route::get('query/release/{mbid}', 'QueryController@getReleaseById');

//API: get release data from MusicBrainz by MBID
Route::get('/query/release_mb/{mbid}', 'QueryController@getReleaseByMBID');

//SITE: artist page
Route::get('/artist/{artist_id}/{page_number?}', "ArtistController@show")
  ->where(array("artist_id" => "[0-9A-Za-z\-]+", "page_number" => "\d+"));

//SITE: release page
Route::get('/release/{release_id}', 'ReleaseController@show')
  ->where(array("release_id" => "[0-9A-Za-z\-]+"));

Route::get('/artist/{artist_name}/release/{release_id}', 'ReleaseController@showmbid')
  ->where(array("artist_name" => "[0-9A-Za-z\-]+", "release_id" => "[0-9A-Za-z\-]+"));

//SITE: user page
Route::get('/profile/{username}', 'UsersController@getUser');

//AUTHENTICATED
Route::group(array('before' => 'auth'), function() {
  //SITE: logout
  Route::get('/logout', 'UsersController@destroy');
});

//GUEST
Route::group(array('before' => 'guest'), function() {
  //SITE: login
  Route::get('/login', 'UsersController@getLogin');
});

Route::controller('users', 'UsersController');

//SITE: post to homepage
Route::post('/', 'QueryController@postSearch');

//SITE: homepage
Route::get('/', array('as' => 'home', function()
{
  return View::make('home')->with(array("artist" => null, "album" => null));
}));
