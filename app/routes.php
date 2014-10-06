<?php

Route::get('/', function()
{
    return Redirect::to('games/pending');
});

Route::get('games/pending', array('before' => 'auth', 'uses' => 'HomeController@showMain'));

// Bets
Route::post('bets', 'BetsController@store');
Route::get('bets/current', array('before' => 'auth', 'uses' => 'BetsController@showCurrentBets'));


// Confide routes
Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');

Route::get('users/profile', array('before' => 'auth', 'uses' => 'UsersController@profile'));
Route::post('users/profile', array('before' => 'auth', 'uses' => 'UsersController@update'));