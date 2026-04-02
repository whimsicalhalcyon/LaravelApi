<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NewsController;


Route::middleware('api')
    ->prefix('api')
    ->group(base_path('routes/api.php'));


// пути с blade-шаблонами
Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('welcome');
Route::get('/user/registration', [\App\Http\Controllers\PageController::class, 'registration'])->name('user.registration');
Route::post('/user/reg', [\App\Http\Controllers\UserController::class, 'reg'])->name('user.reg');
Route::get('/user/authorization', [\App\Http\Controllers\PageController::class, 'authorization'])->name('user.authorization');
Route::post('/user/auth', [\App\Http\Controllers\UserController::class, 'auth'])->name('user.auth');
Route::get('/user/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('user.logout');
Route::get('/emails/reply', [\App\Http\Controllers\PageController::class, 'reply'])->name('emails.reply');
Route::get('/cors', [\App\Http\Controllers\PageController::class, 'cors'])->name('cors');
Route::get('/widgets/contact', [\App\Http\Controllers\PageController::class, 'widget_contact'])->name('widget_contact');
Route::get('/widgets/iframe_demo', [\App\Http\Controllers\PageController::class, 'iframe_demo'])->name('iframe_demo');
