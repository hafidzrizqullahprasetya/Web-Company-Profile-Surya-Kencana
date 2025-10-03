<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisionMissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Vision and Mission Routes
Route::get('/vision-mission', [VisionMissionController::class, 'index']);

//Product Routes
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    //Vision and Mission Routes
    Route::put('/vision-mission/{id}', [VisionMissionController::class, 'update']);

    //Admin Routes
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/{id}', [AdminController::class, 'show']);
    Route::post('/admin', [AdminController::class, 'store']);
    Route::put('/admin/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/{id}', [AdminController::class, 'destroy']);

    //Product Routes
    Route::post('/product', [ProductController::class, 'store']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);

});
