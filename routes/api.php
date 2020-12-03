<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
        'middleware' => 'api', 
        'prefix' => 'auth', 
        'namespace' => 'App\Http\Controllers'
    ], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/user', 'AuthController@userProfile');
});


Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    Route::resource('company', 'CompanyController');
    Route::resource('employee', 'EmployeeController');
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');

    Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
});