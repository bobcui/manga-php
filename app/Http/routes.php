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

use Illuminate\Support\Facades\Config;

Route::group(array('prefix' => 'v1'), function() {
    Route::get('/configs', function(){
        return response()->json(Config::get('manga'));
    });

    Route::resource('mangas', 'MangaController', ['only' => ['index', 'show']]);
    Route::resource('categories', 'CategoryController', ['only' => ['index']]);
});