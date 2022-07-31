<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/todos/total', [App\Http\Controllers\Api\TodoListController::class, 'total']);
Route::get('/todos/toal_uncompleted', [App\Http\Controllers\Api\TodoListController::class, 'totalUncompleted']);
Route::get('/todos/total_completed', [App\Http\Controllers\Api\TodoListController::class, 'totalCompleted']);

Route::get('/todos', [App\Http\Controllers\Api\TodoListController::class, 'show']);
Route::get('/todos/{id}/edit', [App\Http\Controllers\Api\TodoListController::class, 'edit']);
Route::post('/todos/store', [App\Http\Controllers\Api\TodoListController::class, 'store']);
Route::put('/todos/{id}/complete', [App\Http\Controllers\Api\TodoListController::class, 'complete']);
Route::delete('/todos/{id}/destroy', [App\Http\Controllers\Api\TodoListController::class, 'destroy']);