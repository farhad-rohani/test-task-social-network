<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MessagesController;
use App\Http\Controllers\Api\ProfilesController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('profile', ProfilesController::class)->except('index');

    Route::apiResource('user', UsersController::class, ['names' => 'user'])->only('index', 'show', 'destroy');
    Route::controller(UsersController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('{user:name}/follow', 'follow')->name('follow');
        Route::get('{user}/followers', 'followers')->name('followers');
        Route::get('{user}/followings', 'followings')->name('followings');
    });

    Route::apiResource('message', MessagesController::class);
});
