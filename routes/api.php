<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;

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
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/couriers', [CourierController::class, 'store']);
    Route::get('/couriers/{id}', [CourierController::class, 'show']);
    Route::patch('/couriers/{id}', [CourierController::class, 'update']);

    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/assign', [OrderController::class, 'assign']);
    Route::post('/orders/complete', [OrderController::class, 'complete']);

    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
