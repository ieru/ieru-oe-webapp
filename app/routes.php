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

Route::get( '/',                                'HomeController@index' );
Route::post( '/',                               array( 'as'=>'home',         'uses'=>'default@index' ) );

Route::get( '/textual-search',                  array( 'as'=>'search',       'uses'=>'default@search' ) );
Route::post( '/textual-search',                 array( 'as'=>'search',       'uses'=>'default@search' ) );

Route::get( '/navigational-search',             array( 'as'=>'navigational', 'uses'=>'default@navigational' ) );

Route::get( '/browser/resource/(:num)',         array( 'as'=>'resource',     'uses'=>'default@browser' ) );
Route::get( '/browser/resource/(:num)/(\w\w)',  array( 'as'=>'resource',     'uses'=>'default@browser' ) );
Route::get( '/browser/metadata/(:num)',         array( 'as'=>'metadata',     'uses'=>'default@metadata' ) );

Route::get( '/register',                        array( 'as'=>'register',     'uses'=>'default@register' ) );



Route::get( '/admin/', 'AdminController@home' );

Route::get(  '/admin/langfiles',                'AdminController@langfiles' );
Route::get(  '/admin/langfiles/',               'AdminController@langfiles' );
Route::post( '/admin/langfiles',                'AdminController@langfilessend' );
Route::post( '/admin/langfiles/',               'AdminController@langfilessend' );

Route::get(  '/admin/langfilesjs',                'AdminController@langfilesjs' );
Route::get(  '/admin/langfilesjs/',               'AdminController@langfilesjs' );
Route::post( '/admin/langfilesjs',                'AdminController@langfilessendjs' );
Route::post( '/admin/langfilesjs/',               'AdminController@langfilessendjs' );