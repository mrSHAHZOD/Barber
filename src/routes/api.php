<?php

use App\Http\Controllers\Api\BranchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\AuthController;

Route::prefix('auth')->group(function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);


    });


});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::apiResource('businesses', BusinessController::class);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('branches', BranchController::class);
});
