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

/**
 * Main routes
 */
Route::get( '/',        	function(){ return Redirect::to('/en/'); } );
Route::get( '/{lang}',  	'HomeController@index' );
Route::get( '/{lang}/', 	'HomeController@index' );

/**
 * Admin zone router
 */
Route::get(  '/{lang}/admin/',						   'AdminController@home' );

Route::get(  '/{lang}/admin/langfiles',                'AdminController@langfiles' );
Route::get(  '/{lang}/admin/langfiles/',               'AdminController@langfiles' );
Route::post( '/{lang}/admin/langfiles',                'AdminController@langfilessend' );
Route::post( '/{lang}/admin/langfiles/',               'AdminController@langfilessend' );

Route::get(  '/{lang}/admin/langfilessuggest',         'AdminController@langfilessuggest' );
Route::get(  '/{lang}/admin/langfilessuggest/',        'AdminController@langfilessuggest' );
Route::post( '/{lang}/admin/langfilessuggest',         'AdminController@langfilessuggestsend' );
Route::post( '/{lang}/admin/langfilessuggest/',        'AdminController@langfilessuggestsend' );

Route::get(  '/{lang}/admin/langfilesjs',              'AdminController@langfilesjs' );
Route::get(  '/{lang}/admin/langfilesjs/',             'AdminController@langfilesjs' );
Route::post( '/{lang}/admin/langfilesjs',              'AdminController@langfilessendjs' );
Route::post( '/{lang}/admin/langfilesjs/',             'AdminController@langfilessendjs' );

Route::get(  '/{lang}/admin/langerror',                'AdminController@langerror' );
Route::get(  '/{lang}/admin/langerror/',               'AdminController@langerror' );
Route::post( '/{lang}/admin/langerror',                'AdminController@langerrorsend' );
Route::post( '/{lang}/admin/langerror/',               'AdminController@langerrorsend' );

Route::get(  '/{lang}/admin/about',                    'AdminController@about' );
Route::get(  '/{lang}/admin/about/',                   'AdminController@about' );
Route::post( '/{lang}/admin/about',                    'AdminController@aboutsend' );
Route::post( '/{lang}/admin/about/',                   'AdminController@aboutsend' );

Route::get(  '/{lang}/admin/term-trends',              'AdminController@termtrends' );
Route::get(  '/{lang}/admin/term-trends/',             'AdminController@termtrends' );
Route::get(  '/{lang}/admin/metadata-statistics',      'AdminController@metadatastatistics' );
Route::get(  '/{lang}/admin/metadata-statistics/',     'AdminController@metadatastatistics' );
Route::get(  '/{lang}/admin/other-services',           'AdminController@otherservices' );
Route::get(  '/{lang}/admin/other-services/',          'AdminController@otherservices' );

Route::get(  '/{lang}/admin/filters',                  'AdminController@filters' );
Route::get(  '/{lang}/admin/filters/',                 'AdminController@filters' );