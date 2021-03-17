<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialiteAuthController;
use Laravel\Socialite\Facades\Socialite;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//User routes
Route::post('/user', [UserController::class, 'store']);
Route::get('/user', [UserController::class, 'show']);

//post routes
Route::post('/post', [PostController::class, 'store']);
Route::get('/post', [PostController::class, 'show']);
Route::get('/posts', [PostController::class, 'showAllForUser']);

//Authentication
Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/auth/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/auth/user',  [AuthController::class, 'user']);

//Socialite routes
Route::middleware('web')->get('/auth/redirect', [SocialiteAuthController::class, 'redirectToGoogle']);
Route::middleware('web')->get('/auth/callback', [SocialiteAuthController::class, 'googleCallback']);

Route::post('/fileUpload', [PostController::class, 'uploadFile']);
Route::get('/fileUpload', [PostController::class, 'getFile']);
Route::get('/fileUploads', [PostController::class, 'viewUploadsForPost']);




