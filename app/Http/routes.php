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
use App\Models\Attachment;

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
    'attachment',
    function($value) {
        $object = Attachment::find($value);
        
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

Route::get('attachment/add/{poster}', array('as' => 'attachment.add', 'uses' => 'AttachmentController@add', 'middleware' => ['permission:upload-attachment']));
Route::get('attachment/delete/{attachment}', array('as' => 'attachment.delete', 'uses' => 'AttachmentController@delete', 'middleware' => ['permission:upload-attachment']));
Route::post('attachment/upload/{poster}', array('as' => 'attachment.upload', 'uses' => 'AttachmentController@upload', 'middleware' => ['permission:delete-attachment']));
Route::get('attachment/download/{attachment}', array('as' => 'attachment.download', 'uses' => 'AttachmentController@download'));

Route::post('auth/login', array('as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin'));
Route::get('auth/logout', array('as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout'));