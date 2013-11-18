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

//API: get artists releases by MBID with pagination
Route::get('query/artist_releases/{query_string}', 'QueryController@getReleasesByArtistId');

//API: get release by MBID
Route::get('query/release/{mbid}', 'QueryController@getReleaseById')
  ->where(array('mbid' => '[0-9A-Za-z\-]+'));

//SITE: artist page
Route::get('/artist/{artist_id}/{page_number?}', "ArtistController@show")
  ->where(array("artist_id" => "[0-9A-Za-z\-]+", "page_number" => "\d+"));

//SITE: release page
Route::get('/release/{release_id}', "ReleaseController@show")
  ->where(array("release_id" => "[0-9A-Za-z\-]+"));

//SITE: homepage
Route::get('/', array('as' => 'home', function()
{
  return View::make('home');
}));
