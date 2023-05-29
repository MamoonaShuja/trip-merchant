<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\SupplierApi\Http\Controllers\ApiController;

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

Route::middleware('auth:api')->get('/supplierapi', function (Request $request) {
    return $request->user();
});

Route::get("/supplier/{apiName}" , [ApiController::class , "getSingleSupplier"])->name("supplier.apis");
Route::get("/tours/{apiName}/{tourId?}" , [ApiController::class , "getAllTours"])->name('supplier.apis.tour');
