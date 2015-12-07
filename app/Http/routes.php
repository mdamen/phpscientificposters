<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Models\Poster;
use App\Models\File;

// models
Route::bind(
    'poster',
    function($value) {
        $object = Poster::find($value);
        
        if ($object) {
            return $object;
        }
        
        throw new NotFoundHttpException;
    }
);

// models
Route::bind(
    'file',
    function($value) {
        $object = File::find($value);
        
        if ($object) {
            return $object;
        }
        
        throw new NotFoundHttpException;
    }
);

Route::get('/', array('as' => 'poster.list', 'uses' => 'PosterController@index'));
Route::get('poster/details/{poster}', array('as' => 'poster.details', 'uses' => 'PosterController@details'));
Route::get('poster/create', array('as' => 'poster.create', 'uses' => 'PosterController@create', 'middleware' => ['permission:create-poster']));
Route::post('poster/add', array('as' => 'poster.add', 'uses' => 'PosterController@add', 'middleware' => ['permission:create-poster']));
Route::get('poster/edit/{poster}', array('as' => 'poster.edit', 'uses' => 'PosterController@edit', 'middleware' => ['permission:edit-poster']));
Route::post('poster/update/{poster}', array('as' => 'poster.update', 'uses' => 'PosterController@update', 'middleware' => ['permission:edit-poster']));
Route::get('poster/delete/{poster}', array('as' => 'poster.delete', 'uses' => 'PosterController@delete', 'middleware' => ['permission:delete-poster']));

Route::get('file/add/{poster}', array('as' => 'file.add', 'uses' => 'FileController@add', 'middleware' => ['permission:upload-file']));
Route::get('file/delete/{file}', array('as' => 'file.delete', 'uses' => 'FileController@delete', 'middleware' => ['permission:upload-file']));
Route::post('file/upload/{poster}', array('as' => 'file.upload', 'uses' => 'FileController@upload', 'middleware' => ['permission:delete-file']));
Route::get('file/download/{file}', array('as' => 'file.download', 'uses' => 'FileController@download'));

Route::post('auth/login', array('as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin'));
Route::get('auth/logout', array('as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout'));