<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/users', 'UserController')->middleware("checkRole");

    Route::prefix('/todos')->group(function() {
        Route::get('', [App\Http\Controllers\TodoController::class, 'index']);
        Route::get('/total', [App\Http\Controllers\TodoController::class, 'total']);
        Route::get('/total_uncompleted', [App\Http\Controllers\TodoController::class, 'totalUncompleted']);
        Route::get('/total_completed', [App\Http\Controllers\TodoController::class, 'totalCompleted']);
        Route::get('/{id}/edit', [App\Http\Controllers\TodoController::class, 'edit']);
        Route::post('/store', [App\Http\Controllers\TodoController::class, 'store']);
        Route::put('/{id}/complete', [App\Http\Controllers\TodoController::class, 'complete']);
        Route::put('/{id}/uncomplete', [App\Http\Controllers\TodoController::class, 'uncomplete']);
        Route::put('/{id}/update', [App\Http\Controllers\TodoController::class, 'update']);
        Route::delete('/{id}/destroy', [App\Http\Controllers\TodoController::class, 'destroy'])->name('todos.destroy');
    });
    
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });

});





