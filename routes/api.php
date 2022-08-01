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

Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {

    // module : todo
    Route::prefix('/todos')->group(function() {
        Route::get('/total', [App\Http\Controllers\Api\TodoListController::class, 'total']);
        Route::get('/total_uncompleted', [App\Http\Controllers\Api\TodoListController::class, 'totalUncompleted']);
        Route::get('/total_completed', [App\Http\Controllers\Api\TodoListController::class, 'totalCompleted']);
        Route::get('', [App\Http\Controllers\Api\TodoListController::class, 'show']);
        Route::get('/{id}/specific-show', [App\Http\Controllers\Api\TodoListController::class, 'specificShow']);
        Route::get('/{id}/edit', [App\Http\Controllers\Api\TodoListController::class, 'edit']);
        Route::post('/store', [App\Http\Controllers\Api\TodoListController::class, 'store']);
        Route::put('/{id}/complete', [App\Http\Controllers\Api\TodoListController::class, 'complete']);
        Route::put('/{id}/uncomplete', [App\Http\Controllers\Api\TodoListController::class, 'uncomplete']);
        Route::put('/{id}/update', [App\Http\Controllers\Api\TodoListController::class, 'update']);
        Route::delete('/{id}/destroy', [App\Http\Controllers\Api\TodoListController::class, 'destroy']);
    });
    
});

