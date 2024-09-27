<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
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

// Book Routes
Route::apiResource('books', BookController::class);
Route::get('categories/{categoryId}/books', [BookController::class, 'indexByACategory']);
Route::get('categories/{categoryId}/books/active', [BookController::class, 'indexActiveBooks']);
Route::get('/categories/books', [BookController::class, 'indexByAllCategories']);

// Category Routes
Route::apiResource('categories', CategoryController::class);
