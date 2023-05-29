<?php

use Illuminate\Support\Facades\Route;
use Modules\Organizer\Http\Controllers\AuthenticationController;
use Modules\Organizer\Http\Controllers\MembersController;
use Modules\Organizer\Http\Controllers\SettingsController;
use Modules\Organizer\Http\Controllers\SubscribersController;
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

Route::prefix('organizer/')->group(function () {
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
        Route::get("get-members", [MembersController::class, "getMembers"]);
        Route::get("get-subscribers", [SubscribersController::class, "getSubscribers"]);
        //settings api
        Route::middleware('organizer')->group(function (){
            Route::patch('update-settings', [SettingsController::class, 'updateSettings']);
            Route::patch('update-settings-slider/{uuid}', [SettingsController::class, 'updateSlider']);
            Route::delete('delete-settings-slider/{uuid}', [SettingsController::class, 'deleteSlider']);
            Route::get('settings', [SettingsController::class, 'settings']);
        });

    });
});
