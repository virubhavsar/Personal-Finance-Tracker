<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

Route::post('login', [PassportAuthController::class, 'login'])->name('login');
Route::post('register', [PassportAuthController::class, 'register']);
Route::get('users', [UserController::class, 'users_manage']);

Route::put('/users/{id}/toggle-active', [UserController::class, 'toggleActiveStatus']);
Route::put('/users/{id}', [UserController::class, 'editUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

Route::middleware('auth:api')->group(function () {
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category/store', [CategoryController::class, 'store']);
    Route::put('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'delete']);

    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::post('/transaction/store', [TransactionController::class, 'store']);
    Route::put('/transaction/update/{id}', [TransactionController::class, 'update']);
    Route::delete('/transaction/delete/{id}', [TransactionController::class, 'delete']);

    Route::get('/budget', [BudgetController::class, 'index']);
    Route::post('/budget/store', [BudgetController::class, 'store']);
    Route::put('/budget/update/{id}', [BudgetController::class, 'update']);
    Route::delete('/budget/delete/{id}', [BudgetController::class, 'delete']);
    Route::get('/budget', [BudgetController::class, 'index']);


});
