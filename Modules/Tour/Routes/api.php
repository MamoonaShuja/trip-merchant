<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Organizer\Http\Controllers\SettingsController;
use Modules\Tour\Http\Controllers\CityController;
use Modules\Tour\Http\Controllers\CountryController;
use Modules\Tour\Http\Controllers\DestinationController;
use Modules\Tour\Http\Controllers\SearchController;
use Modules\Tour\Http\Controllers\TourController;
use Modules\Tour\Http\Controllers\TravelStyleController;

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

Route::get("trip/getAll/{uuid?}" , [TourController::class , "getForOrganization"]);
Route::get("trip/getAll-with-deals" , [TourController::class , "getWithDeals"]);
Route::get("trip/get/{uuid}" , [TourController::class , "get"]);
Route::get("travel-styles", [TravelStyleController::class , "getTravelStyles"]);
Route::get("travel-style/{id}", [TravelStyleController::class , "getById"]);
Route::get("organizer-settings/{uuid}", [SettingsController::class , "settings"]);
Route::get("cities", [CityController::class , "getCities"]);
Route::get("city/{id}", [CityController::class , "getById"]);
Route::get("countries", [CountryController::class , "get"]);
Route::get("country/{uuid}", [CountryController::class , "getById"]);
Route::get("destinations", [DestinationController::class , "getDestinations"]);
Route::get("destination/{id}", [DestinationController::class , "getById"]);
Route::get("trip/filter", [SearchController::class , "generalFilter"]);
Route::get("trip/guided-tour/filter", [SearchController::class , "guidedTourFilter"]);
Route::get("get/{type}" , [UserController::class , "getAll"]);



