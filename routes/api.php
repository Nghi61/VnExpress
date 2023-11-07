<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentsController;

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

Route::apiResource("/users", UsersController::class);
Route::apiResource("/category", CategoryController::class);
Route::apiResource("news", NewsController::class);
Route::apiResource("comment", CommentsController::class);
Route::post('/upload/news', [NewsController::class, 'upload']);
Route::post('/upload/user', [UsersController::class, 'upload']);
Route::put('/profile/{id}', [AuthController::class, 'profile']);
Route::get('/users/search/{query}', [UsersController::class, 'search']);
Route::get('/category/search/{query}', [CategoryController::class, 'search']);
Route::get('/news/search/{query}', [NewsController::class, 'search']);
Route::get('/news/category/{slug}', [NewsController::class,'NewsBySlug']);
Route::get('/comment/search/{query}', [CommentsController::class, 'search']);
Route::get('/comment/detail/{id}', [CommentsController::class, 'getComment']);
Route::post('/login',[AuthController::class,'Login']);
Route::post('/forget-password',[AuthController::class,'forgetPassword']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/isadmin',[AuthController::class,'isAdmin']);
