<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controller class
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
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

Route::middleware('api')->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
    });

    Route::post('/signup', [UserController::class, 'store']);

    Route::middleware('jwt')->group(function () {
        Route::prefix('auth')->controller(AuthController::class)->group(function () {
            Route::post('logout', 'logout');
        });

        Route::prefix('task')->controller(TaskController::class)->group(function () {
            Route::post('create', 'store');
            Route::put('update/{id}', 'update');
            Route::delete('delete/{id}', 'destroy');
            Route::get('show/{id}', 'show');
            Route::get('/list', 'index');
        });

        Route::prefix('task-status')->controller(TaskStatusController::class)->group(function () {
            Route::get('list', 'index');
        });
    });
});
