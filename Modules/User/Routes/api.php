<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Modules\Tour\Http\Controllers\DestinationController;
use Modules\Tour\Http\Controllers\TourQuoteController;
use Modules\User\Http\Controllers\AuthenticationController;
use Modules\User\Http\Controllers\SubscriberController;
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
Route::prefix('member/')->group(function () {
    Route::prefix("authentication/")->group(function () {
        Route::post("register", [AuthenticationController::class, "signUp"]);
        Route::post("login", [AuthenticationController::class, "signIn"]);
        Route::post('forget-password', [AuthenticationController::class, 'forgetPassword']);
        Route::post('password/reset', [AuthenticationController::class, 'resetPassword'])->name('password.reset');
        Route::post('subscribe', [SubscriberController::class, 'subscribe']);
        Route::delete('unsubscribe/{uuid}', [SubscriberController::class, 'unSubscribe']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get("", [UserController::class, "getAuthUser"]);
        Route::patch("", [UserController::class, "updateAuthUser"]);
        Route::post("password", [UserController::class, "changePassword"]);
        Route::post("upload-avatar", [UserController::class, "uploadAvatar"]);
        Route::get("destinations", [DestinationController::class , "getDestinations"]);
        Route::prefix("destination/")->group(function (){
            Route::get("{id}", [DestinationController::class , "getById"]);
        });
        Route::post("tour/quote" , [TourQuoteController::class , "store"]);
    });
});

Route::get("get-exodus" , function (){
   $data = Http::get("https://www.exodus.co.uk/api/v4/trip/xml/MOV");
   $xml = simplexml_load_string($data->body());
   $json = json_encode($xml);
   return ($json);
});
Route::get("get-avalon" , function (){
   $data = Http::get("https://webapi.globusandcosmos.com/gvitawapi.asmx/GetAllAvailableMediaTours");
   $xml = simplexml_load_string($data->body());
   dd($data);
   $json = json_encode($xml);
   return ($json);
});
