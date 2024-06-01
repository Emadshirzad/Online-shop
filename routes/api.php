<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::get('refresh', [AuthController::class,'refresh']);
    Route::get('me', [AuthController::class,'me']);
    Route::group(['prefix' => 'password'], function () {
        Route::post('forgot', [AuthController::class,'forgot']);
        Route::get('forgotPassword/{token}', [AuthController::class, 'getForgotView'])->name('forgot.password');
        Route::post('forgotPassword/{token}', [AuthController::class, 'setForgotPassword'])->name('change-password');
    });
});
