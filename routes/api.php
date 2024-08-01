<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostCategoryController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

// Post routes
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{id}', [PostController::class, 'show']);
Route::post('posts', [PostController::class, 'store']);
Route::put('posts/{id}', [PostController::class, 'update']);
Route::delete('posts/{id}', [PostController::class, 'destroy']);

// Category routes
Route::get('post-categories', [PostCategoryController::class, 'index']);
Route::post('post-categories', [PostCategoryController::class, 'store']);
Route::put('post-categories/{id}', [PostCategoryController::class, 'update']);
Route::delete('post-categories/{id}', [PostCategoryController::class, 'destroy']);

