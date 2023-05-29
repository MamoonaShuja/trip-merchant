<?php

use Illuminate\Support\Facades\Route;
use Modules\SupplierApi\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/supplier/{apiName}" , [ApiController::class , "getSingleSupplier"])->name("supplier.apis");
Route::get("/tours/{apiName}/{tourId?}" , [ApiController::class , "getAllTours"])->name('supplier.apis.tour');

Route::get('/',function(){
   return view('welcome');
});


