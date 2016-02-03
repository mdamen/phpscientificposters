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
use App\Models\User;

// models
Route::bind(
    'poster',
    function($value) {
        $object = Poster::withTrashed()->find($value);
        
        if ($object) {
            return $object;
        }
        
        throw new NotFoundHttpException;
    }
);

Route::bind(
    'attachment',
    function($value) {
        $object = Attachment::withTrashed()->find($value);
        
        if ($object) {
            return $object;
        }
        
        throw new NotFoundHttpException;
    }
);

Route::bind(
    'user',
    function($value) {
        $object = User::find($value);
        
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
Route::get('poster/restore/{poster}', array('as' => 'poster.restore', 'uses' => 'PosterController@restore', 'middleware' => ['role:admin']));
Route::get('poster/forcedelete/{poster}', array('as' => 'poster.forcedelete', 'uses' => 'PosterController@forcedelete', 'middleware' => ['role:admin']));

Route::get('attachment/add/{poster}', array('as' => 'attachment.add', 'uses' => 'AttachmentController@add', 'middleware' => ['permission:upload-attachment']));
Route::get('attachment/delete/{attachment}', array('as' => 'attachment.delete', 'uses' => 'AttachmentController@delete', 'middleware' => ['permission:upload-attachment']));
Route::post('attachment/upload/{poster}', array('as' => 'attachment.upload', 'uses' => 'AttachmentController@upload', 'middleware' => ['permission:delete-attachment']));
Route::get('attachment/download/{attachment}', array('as' => 'attachment.download', 'uses' => 'AttachmentController@download'));
Route::get('attachment/restore/{attachment}', array('as' => 'attachment.restore', 'uses' => 'AttachmentController@restore', 'middleware' => ['role:admin']));
Route::get('attachment/forcedelete/{attachment}', array('as' => 'attachment.forcedelete', 'uses' => 'AttachmentController@forcedelete', 'middleware' => ['role:admin']));

Route::post('auth/login', array('as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin'));
Route::get('auth/logout', array('as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout'));

Route::get('recyclebin', array('as' => 'recyclebin', 'uses' => 'RecycleBinController@index', 'middleware' => ['role:admin']));
Route::get('user', array('as' => 'user.list', 'uses' => 'UserController@index', 'middleware' => ['role:admin']));
Route::get('user/details/{user}', array('as' => 'user.details', 'uses' => 'UserController@details', 'middleware' => ['role:admin']));
Route::get('user/create', array('as' => 'user.create', 'uses' => 'UserController@create', 'middleware' => ['permission:create-user']));
Route::post('user/add', array('as' => 'user.add', 'uses' => 'UserController@add', 'middleware' => ['permission:create-user']));
Route::get('user/edit/{user}', array('as' => 'user.edit', 'uses' => 'UserController@edit', 'middleware' => ['permission:edit-user']));
Route::post('user/update/{user}', array('as' => 'user.update', 'uses' => 'UserController@update', 'middleware' => ['permission:edit-user']));
Route::get('user/delete/{user}', array('as' => 'user.delete', 'uses' => 'UserController@delete', 'middleware' => ['permission:delete-user']));