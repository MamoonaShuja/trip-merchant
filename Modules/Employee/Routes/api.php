<?php

use Illuminate\Support\Facades\Route;
use Modules\Employee\Http\Controllers\AuthenticationController;
use Modules\User\Http\Controllers\UserController;

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

Route::prefix('employee/')->group(function () {
    Route::prefix("authentication/")->group(function () {
        Route::post("register", [AuthenticationController::class, "signUp"]);
        Route::post("login", [AuthenticationController::class, "signIn"]);
        Route::post('forget-password', [AuthenticationController::class, 'forgetPassword']);
        Route::post('password/reset', [AuthenticationController::class, 'resetPassword']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get("", [UserController::class, "getAuthUser"]);
        Route::patch("", [UserController::class, "updateAuthUser"]);
        Route::post("password", [UserController::class, "changePassword"]);
        Route::post("upload-avatar", [UserController::class, "uploadAvatar"]);
    });
});
