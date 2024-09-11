<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TabController;

Route::get('/tabs', [TabController::class, 'index']);
Route::get('/tabs/{id}', [TabController::class, 'index']);
Route::post('/tabs', [TabController::class, 'store']);
Route::put('/tabs/{id}', [TabController::class, 'update']);
Route::delete('/tabs/{id}', [TabController::class, 'destroy']);
