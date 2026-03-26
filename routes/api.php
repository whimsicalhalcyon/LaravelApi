<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ReplyController;

Route::apiResource('messages', MessageController::class);
Route::post('replies', [ReplyController::class, 'store']);

Route::get('/messages-api', [MessageController::class, 'index']);
