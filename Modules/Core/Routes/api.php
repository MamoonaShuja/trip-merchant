<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\ScheduleDemoController;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Core\Http\Controllers\PermissionController;
use Modules\Core\Http\Controllers\RoleController;
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

Route::get("/health", [CoreController::class, "health"]);

Route::post('subscribe', [SubscriberController::class, 'subscribe']);
Route::delete('unsubscribe/{uuid}', [SubscriberController::class, 'unSubscribe']);
Route::get('checkDomain/{domain}', [UserController::class, 'checkDomain']);

Route::post('schedule-demo/create', [ScheduleDemoController::class, 'store'])->name('schedule.demo.store');

