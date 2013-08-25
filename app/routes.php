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

Route::get('/', function(){
    $title = 'Inicio';

    return View::make('inicio')
    ->with('title', $title);
});

Route::get('login', 'UserController@getIndex');
Route::get('logout', 'UserController@getLogout');

Route::controller('users', 'UserController');

Route::group(array('before' => 'auth'), function()
{
    Route::controller('articles', 'ArticleController');
    Route::controller('branches', 'BrancheController');
    Route::controller('roles', 'RoleController');
});

Route::get('u', function() {
    // $u = Auth::User()->first()->orderBy('created_at', 'desc')->first()->id;
    $u = Auth::user()->roles()->first()->branch->name;
    die(var_dump($u));
});