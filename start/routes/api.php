<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RedemptionController;



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    //admin- register new staff
    Route::middleware('role:admin')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/redemptions', [RedemptionController::class, 'allRedemptions']);
    });

    //admin staff
    Route::middleware('role:admin, staff')->group(function () {
        Route::get('/guests', [GuestController::class, 'index']);
        Route::post('/guests', [GuestController::class, 'store']);
        Route::post('/redeem',  [RedemptionController::class, 'redeem']);
        Route::get('/redeem/history/{code}', [RedemptionController::class, 'history']);

    });

    //admin, staff, scanner
    Route::middleware('role:admin, staff, scanner')->group(function () {
        Route::get('/guests/ticket/{code}', [GuestController::class, 'findByTicket']);
        Route::post('/guests/ticket/{code}/checkin', [GuestController::class, 'checkIn']);
       
    });
});