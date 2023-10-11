<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('users/login', [AuthController::class, 'userLogin']);
Route::post('users/register', [UserController::class, 'store']);
Route::post("customer/login", [AuthController::class, 'customerLogin']);


Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource("/user", UserController::class);
    Route::apiResource("/customer", CustomerController::class);
    Route::apiResource("customer/balance", BalanceController::class);

    Route::apiResource("/transaction", TransactionController::class);
});
