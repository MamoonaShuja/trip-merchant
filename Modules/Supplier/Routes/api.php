<?php

use Illuminate\Support\Facades\Route;
use Modules\Supplier\Http\Controllers\AuthenticationController;
use Modules\Supplier\Http\Controllers\SupplierController;
use Modules\Tour\Http\Controllers\CityController;
use Modules\Tour\Http\Controllers\CountryController;
use Modules\Tour\Http\Controllers\DestinationController;
use Modules\Tour\Http\Controllers\TourController;
use Modules\Tour\Http\Controllers\TravelStyleController;
use Modules\Supplier\Http\Controllers\UserController;
use Modules\Core\Enum\Permissions\Trip as TripPermission;

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

Route::prefix('supplier/')->group(function () {
    Route::prefix("authentication/")->group(function () {
        Route::post("register", [AuthenticationController::class, "signUp"]);
        Route::post("login", [AuthenticationController::class, "signIn"]);
        Route::post('forget-password', [AuthenticationController::class, 'forgetPassword']);
        Route::post('password/reset', [AuthenticationController::class, 'resetPassword']);
    });

    Route::middleware(['auth:sanctum', 'supplier'])->group(function () {
        Route::get("", [UserController::class, "getAuthUser"]);
        Route::patch("", [UserController::class, "updateAuthUser"]);
        Route::post("password", [UserController::class, "changePassword"]);
        Route::patch("upload-avatar", [UserController::class, "uploadAvatar"]);
        Route::patch("upload-logo", [UserController::class, "uploadLogo"]);
        Route::patch("update-about-us", [UserController::class, "updateAboutUs"]);
        Route::prefix("trip")->group(function () {
            Route::post("/create", [TourController::class, "create"]);
            Route::get("/getAll", [TourController::class, "getAll"]);
            Route::get("/get/{uuid}", [TourController::class, "get"]);
            Route::delete("/delete/{uuid}", [TourController::class, "delete"]);
            Route::get("/deleted", [TourController::class, "getDeleted"]);
            Route::patch("/update/{uuid}", [TourController::class, "update"]);
            Route::patch("/update/gallery/{uuid}", [TourController::class, "updateGallery"]);
            Route::post("/update/slider/{uuid}", [TourController::class, "updateSlider"]);
            Route::delete("/delete/{uuid}/{type}/{mediaId}", [TourController::class, "deleteFile"])->whereIn("type", [
                \Modules\Tour\Enum\MediaTypes::SLIDER->value,
                \Modules\Tour\Enum\MediaTypes::GALLERY->value,
                \Modules\Tour\Enum\MediaTypes::CABIN_DECKS->value,
            ]);
            Route::post("/update/cabin-decks/{uuid}", [TourController::class, "updateCabinDecks"]);
            Route::delete("/delete/{uuid}/gallery/{fileName}", [TourController::class, "deleteGalleryFile"]);
            Route::delete("/delete/{uuid}/cabin-deck/{fileName}", [TourController::class, "deleteCabinDeckFile"]);
        });
        Route::get("travelStyles", [TravelStyleController::class, "getTravelStyles"]);
        Route::get("cities", [CityController::class, "getCities"]);
        Route::get("city/{id}", [CityController::class, "getById"]);
        Route::get("countries", [CountryController::class, "get"]);
        Route::get("country/{uuid}", [CountryController::class, "getById"]);
        Route::get("destinations", [DestinationController::class, "getDestinations"]);
        Route::get("destination/{id}", [DestinationController::class, "getById"]);

    });
});
