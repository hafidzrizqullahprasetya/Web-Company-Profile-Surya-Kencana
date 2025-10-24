<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisionMissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OurClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonialController;


//Authentication Routes
Route::post('admin/login', [AuthController::class, 'adminLogin']);
Route::post('superadmin/login', [AuthController::class, 'superAdminLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Vision and Mission Routes
Route::get('/vision-mission', [VisionMissionController::class, 'index']);

//Product Routes
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

//Client Routes
Route::get('/our-client', [OurClientController::class, 'index']);
Route::get('/our-client/{id}', [OurClientController::class, 'show']);

//Contact Routes
Route::get('/contact', [ContactController::class, 'index']);

//Testimonial Routes
Route::get('/testimonial', [TestimonialController::class, 'index']);

//Middleware Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    //Vision and Mission Routes
    Route::put('/vision-mission', [VisionMissionController::class, 'update']);

    //Contact Routes
    Route::put('/contact', [ContactController::class, 'update']);

    //Admin Routes
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/{id}', [AdminController::class, 'show']);
    Route::post('/admin', [AdminController::class, 'store']);
    Route::put('/admin/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/{id}', [AdminController::class, 'destroy']);

    //Product Routes
    Route::post('/product', [ProductController::class, 'store']);
    Route::post('/product/{id}', [ProductController::class, 'update']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);

    //Client Routes
    Route::post('/our-client', [OurClientController::class, 'store']);
    Route::post('/our-client/{id}', [OurClientController::class, 'update']);
    Route::put('/our-client/{id}', [OurClientController::class, 'update']);
    Route::delete('/our-client/{id}', [OurClientController::class, 'destroy']);

    //Testimonial Routes
    Route::post('/testimonial', [TestimonialController::class, 'store']);
    Route::put('/testimonial/{id}', [TestimonialController::class, 'update']);
    Route::delete('/testimonial/{id}', [TestimonialController::class, 'destroy']);
});
