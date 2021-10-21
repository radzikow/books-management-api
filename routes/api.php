<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Books\OpinionController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Authorization endpoints
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// Books endpoints
Route::group(['prefix' => 'books'], function () {
    Route::get('', [BookController::class, 'index']);
    Route::get('{book_id}', [BookController::class, 'show'])
        ->where('book_id', '[0-9]+');
});

// User books endpoints
Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'books'], function () {
        Route::get('', [UserController::class, 'userBooks']);
        Route::post('add', [BookController::class, 'store']);
        Route::group(['prefix' => '{book_id}'], function () {
            Route::get('', [UserController::class, 'userBook'])
                ->where('book_id', '[0-9]+');
            Route::put('edit', [BookController::class, 'update'])
                ->where('book_id', '[0-9]+');
            Route::delete('delete', [BookController::class, 'destroy'])
                ->where('book_id', '[0-9]+');
        });
    });
    Route::get('opinions', [UserController::class, 'userBooksOpinions']);
});

// Opinions endpoints
Route::group(['prefix' => 'opinions'], function () {
    Route::get('', [OpinionController::class, 'index']);
    Route::get('{opinion_id}', [OpinionController::class, 'show'])
        ->where('opinion_id', '[0-9]+');
    Route::post('add', [OpinionController::class, 'store']);
});
