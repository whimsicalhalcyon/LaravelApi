<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CorsUrlController;

Route::apiResource('messages', MessageController::class);
Route::apiResource('replies', ReplyController::class);
Route::apiResource('news', NewsController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('cors', CorsUrlController::class);

Route::get('/messages-api', [MessageController::class, 'index']);
