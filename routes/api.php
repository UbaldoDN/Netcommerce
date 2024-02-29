<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CompanyController;

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
Route::prefix('/companies')->controller(CompanyController::class)->group(function () {
    Route::get('/{search?}', 'index');
    Route::get('/{company}', 'show');
    Route::post('/', 'store');
    Route::put('/{company}', 'update');
    Route::delete('/{company}', 'destroy');
});

Route::prefix('/tasks')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{task}', 'show');
    Route::post('/', 'store');
    Route::put('/{task}', 'update');
    Route::delete('/{task}', 'destroy');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/{user}', 'show');
    Route::post('/users', 'store');
    Route::put('/users/{user}', 'update');
    Route::delete('/users/{user}', 'destroy');
});
