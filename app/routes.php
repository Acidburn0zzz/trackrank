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

Route::get('/', array('as' => 'home', function()
{
  return View::make('home');
}));

Route::get('query/search/artist/{query_string}', 'QueryController@getSearchArtist');
Route::get('query/search/album/{query_string}', 'QueryController@getSearchAlbum');
//Route::controller('query', 'QueryController');