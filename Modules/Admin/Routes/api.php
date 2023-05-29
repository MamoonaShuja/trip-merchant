<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\AuthenticationController;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Core\Http\Controllers\PermissionController;
use Modules\Core\Http\Controllers\RoleController;
use Modules\Core\Http\Controllers\ScheduleDemoController;
use Modules\Tour\Http\Controllers\CityController;
use Modules\Tour\Http\Controllers\CountryController;
use Modules\Tour\Http\Controllers\DestinationController;
use Modules\Tour\Http\Controllers\TourController;
use Modules\Tour\Http\Controllers\TourQuoteController;
use Modules\Tour\Http\Controllers\TravelStyleController;
use Modules\User\Enum\UserType;
use Modules\User\Http\Controllers\SubscriberController;
use Modules\Core\Enum\Permissions\Destination as DestinationPermission;
use Modules\Core\Enum\Permissions\TravelStyle as TravelStylePermission;
use Modules\Core\Enum\Permissions\Country as CountryPermission;
use Modules\Core\Enum\Permissions\City as CityPermission;
use Modules\Core\Enum\Permissions\Trip as TripPermission;
use Modules\Core\Enum\Permissions\Subscriber as SubscriberPermission;
use Modules\Core\Enum\Permissions\User as UserPermission;

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

Route::prefix('admin/')->group(function () {
    Route::prefix("authentication/")->group(function () {
        Route::post("login", [AuthenticationController::class, "signIn"]);
        Route::post('forget-password', [AuthenticationController::class, 'forgetPassword']);
        Route::post('password/reset', [AuthenticationController::class, 'resetPassword']);
    });

});
Route::middleware(['auth:sanctum'])->prefix("admin/")->group(function () {

    //profile
    Route::get("", [AdminController::class, "getAuthUser"]);
    Route::patch("", [AdminController::class, "updateAuthUser"]);
    Route::patch("password", [AdminController::class, "changePassword"]);
    Route::patch("upload-avatar", [AdminController::class, "uploadAvatar"]);

//    Destination apis
    Route::get("destinations", [DestinationController::class, "getDestinations"])->middleware('admin:' . DestinationPermission::GET_DESTINATIONS->value);
    Route::prefix("destination/")->group(function () {
        Route::post("create", [DestinationController::class, "store"])->middleware('admin:' . DestinationPermission::STORE_DESTINATION->value);
        Route::get("{id}", [DestinationController::class, "getById"])->middleware('admin:' . DestinationPermission::SHOW_DESTINATION->value);
        Route::delete("{id}", [DestinationController::class, "destroy"])->middleware('admin:' . DestinationPermission::DELETE_DESTINATION->value);
        Route::patch("{id}", [DestinationController::class, "update"])->middleware('admin:' . DestinationPermission::UPDATE_DESTINATION->value);
    });

//    TravelStyle apis
    Route::get("travelStyles", [TravelStyleController::class, "getTravelStyles"])->middleware('admin:' . TravelStylePermission::GET_TRAVEL_STYLES->value);
    Route::prefix("travel-style/")->group(function () {
        Route::post("create", [TravelStyleController::class, "store"])->middleware('admin:' . TravelStylePermission::GET_TRAVEL_STYLES->value);
        Route::get("{id}", [TravelStyleController::class, "getById"])->middleware('admin:' . TravelStylePermission::SHOW_TRAVEL_STYLE->value);
        Route::delete("{id}", [TravelStyleController::class, "destroy"])->middleware('admin:' . TravelStylePermission::DELETE_TRAVEL_STYLE->value);
        Route::patch("{id}", [TravelStyleController::class, "update"])->middleware('admin:' . TravelStylePermission::UPDATE_TRAVEL_STYLE->value);
    });

//    Country apis
    Route::get("countries", [CountryController::class, "get"])->middleware('admin:' . CountryPermission::GET_COUNTRIES->value);
    Route::prefix("country/")->group(function () {
        Route::post("create", [CountryController::class, "store"])->middleware('admin:' . CountryPermission::STORE_COUNTRY->value);
        Route::get("{uuid}", [CountryController::class, "getById"])->middleware('admin:' . CountryPermission::SHOW_COUNTRY->value);
        Route::delete("{id}", [CountryController::class, "destroy"])->middleware('admin:' . CountryPermission::DELETE_COUNTRY->value);
        Route::patch("{uuid}", [CountryController::class, "update"])->middleware('admin:' . CountryPermission::UPDATE_COUNTRY->value);
    });

//    City apis
    Route::get("cities", [CityController::class, "getCities"])->middleware('admin:' . CityPermission::GET_CITIES->value);;
    Route::prefix("city/")->group(function () {
        Route::post("create", [CityController::class, "store"])->middleware('admin:' . CityPermission::STORE_CITY->value);
        Route::get("{id}", [CityController::class, "getById"])->middleware('admin:' . CityPermission::SHOW_CITY->value);
        Route::delete("{id}", [CityController::class, "destroy"])->middleware('admin:' . CityPermission::DELETE_CITY->value);
        Route::patch("{id}", [CityController::class, "update"])->middleware('admin:' . CityPermission::UPDATE_CITY->value);
    });
//    User apis
    Route::get("get/" . UserType::ORGANIZER->value, [UserController::class, "getAll"])->middleware("admin:" . UserPermission::GET_ORGANIZERS->value);
    Route::get("get/" . UserType::MEMBER->value, [UserController::class, "getAll"])->middleware("admin:" . UserPermission::GET_MEMBERS->value);;
    Route::get("get/" . UserType::SUPPLIER->value, [UserController::class, "getAll"])->middleware("admin:" . UserPermission::GET_SUPPLIERS->value);;
    Route::get("get/" . UserType::EMPLOYEE->value, [UserController::class, "getAll"])->middleware("admin:" . UserPermission::GET_EMPLOYER->value);;
    Route::get("get/{type}", [UserController::class, "getAll"])->middleware("admin:" . UserPermission::GET_ADMINS->value);
    Route::patch(UserType::ORGANIZER->value . "/change-status/{uuid}", [UserController::class, "updateStatus"])->middleware('admin:' . UserPermission::UPDATE_ORGANIZATION_STATUS->value);
    Route::patch(UserType::SUPPLIER->value . "/change-status/{uuid}", [UserController::class, "updateStatus"])->middleware('admin:' . UserPermission::UPDATE_ORGANIZATION_STATUS->value);
    Route::patch(UserType::SUPPLIER->value . "/change-status/{uuid}", [UserController::class, "updateStatus"])->middleware('admin:' . UserPermission::UPDATE_SUPPLIER_STATUS->value);
    Route::post("/create-admin", [UserController::class, "createAdmin"])->middleware('admin:' . UserPermission::CREATE_ADMIN->value);

    //tour apis

    Route::prefix("trip")->group(function () {
        Route::post("/create", [TourController::class, "create"])->middleware('admin:' . TripPermission::STORE_TRIP->value);
        Route::get("/getAll", [TourController::class, "getAll"])->middleware('admin:' . TripPermission::GET_TRIPS->value);
        Route::get("/get/{uuid}", [TourController::class, "get"])->middleware('admin:' . TripPermission::SHOW_TRIP->value);
        Route::delete("/delete/{uuid}", [TourController::class, "delete"])->middleware('admin:' . TripPermission::DELETE_TRIP->value);
        Route::get("/deleted", [TourController::class, "getDeleted"])->middleware('admin:' . TripPermission::GET_DELETED_TRIPS->value);
        Route::patch("/update/{uuid}", [TourController::class, "update"])->middleware('admin:' . TripPermission::UPDATE_TRIP->value);
        Route::patch("/update/gallery/{uuid}", [TourController::class, "updateGallery"])->middleware('admin:' . TripPermission::UPDATE_TRIP_GALLERY->value);
        Route::post("/update/slider/{uuid}", [TourController::class, "updateSlider"])->middleware('admin:' . TripPermission::UPDATE_TRIP_SLIDER->value);
        Route::delete("/delete/{uuid}/{type}/{mediaId}", [TourController::class, "deleteFile"])->whereIn("type", [
            \Modules\Tour\Enum\MediaTypes::SLIDER->value,
            \Modules\Tour\Enum\MediaTypes::GALLERY->value,
            \Modules\Tour\Enum\MediaTypes::CABIN_DECKS->value,
        ])->middleware('admin:' . TripPermission::DELETE_TRIP_GALLERY->value);
        Route::get("/quotes", [TourQuoteController::class, "get"])->middleware('admin:' . TripPermission::GET_TRIP_QUOTES->value);
        Route::get("/quote/{uuid}", [TourQuoteController::class, "getById"])->middleware('admin:' . TripPermission::SHOW_TRIP_QUOTE->value);
        Route::patch("/quote/{uuid}", [TourQuoteController::class, "update"])->middleware('admin:' . TripPermission::UPDATE_TRIP_QUOTE->value);
        Route::delete("/quote/{uuid}", [TourQuoteController::class, "destroy"])->middleware('admin:' . TripPermission::DELETE_TRIP_QUOTE->value);
    });

    //subscriber api
    Route::post('subscribe', [SubscriberController::class, 'subscribe'])->middleware('admin:' . SubscriberPermission::STORE_SUBSCRIBER->value);
    Route::delete('unsubscribe/{uuid}', [SubscriberController::class, 'unSubscribe'])->middleware('admin:' . SubscriberPermission::SHOW_SUBSCRIBER->value);
    Route::get('subscribers/{organization_uuid?}', [SubscriberController::class, 'getSubscribers'])->middleware('admin:' . SubscriberPermission::GET_SUBSCRIBERS->value);

    //Permission Apis

    Route::get("permissions", [PermissionController::class, "getPermissions"]);
    Route::prefix("permission/")->group(function () {
        Route::post("create", [PermissionController::class, "store"]);
        Route::get("{id}", [PermissionController::class, "getById"]);
        Route::delete("{id}", [PermissionController::class, "destroy"]);
        Route::patch("{id}", [PermissionController::class, "update"]);
    });

//    Roles Api
    Route::get("roles", [RoleController::class, "getRoles"]);
    Route::prefix("role/")->group(function () {
        Route::post("create", [RoleController::class, "store"]);
        Route::get("{id}", [RoleController::class, "getById"]);
        Route::delete("{id}", [RoleController::class, "destroy"]);
        Route::patch("{id}", [RoleController::class, "update"]);
        Route::patch("assign-permission/{uuid}", [RoleController::class, "assignPermission"]);
    });

//    Schedule Demo Api
    Route::get('schedule-demos', [ScheduleDemoController::class, 'getScheduleDemos']);
    Route::prefix("schedule-demo/")->group(function () {
        Route::get("{id}", [ScheduleDemoController::class, "getById"]);
        Route::delete("{id}", [ScheduleDemoController::class, "destroy"]);
    });
});
