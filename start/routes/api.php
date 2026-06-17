<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;

//login strict rate limit
Route::middleware('throttle:login')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware('auth:api', 'throttle:global')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    //admin- register new staff
    Route::middleware('role:admin')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/redemptions', [RedemptionController::class, 'allRedemptions']);
        Route::get('/report/summary',[ReportController::class, 'summary']);
        Route::get('/report/redemptions',[ReportController::class, 'redemptions']);
        Route::get('/report/export', [ReportController::class, 'export']);
    });

    //admin staff
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/guests', [GuestController::class, 'index'])->middleware('throttle:guest-list');
        Route::post('/guests', [GuestController::class, 'store']);
        Route::post('/redeem',  [RedemptionController::class, 'redeem'])->middleware('throttle:redemption');
        Route::get('/redeem/history/{code}', [RedemptionController::class, 'history']);
        Route::get('/inventory', [InventoryController::class, 'index']);
        Route::post('/inventory', [InventoryController::class, 'store']);
        Route::put('/inventory/{id}',[InventoryController::class, 'update']);
        Route::delete('/inventory/{id}',[InventoryController::class, 'destroy']);
    });

    //admin, staff, scanner
    Route::middleware('role:admin,staff,scanner')->group(function () {
        Route::get('/guests/ticket/{code}', [GuestController::class, 'findByTicket'])->middleware('throttle:scanning');
        Route::post('/guests/ticket/{code}/checkin', [GuestController::class, 'checkIn'])->middleware('throttle:scanning');

    });
});