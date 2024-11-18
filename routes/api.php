<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('user-ratings', RatingController::class);

Route::apiResource('products', ProductController::class);