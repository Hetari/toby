<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TabController;

Route::get('/collections', [TabController::class, 'index']);
Route::get('/collections/{id}', [TabController::class, 'index']);
Route::post('/collections', [TabController::class, 'store']);
Route::put('/collections/{id}', [TabController::class, 'update']);
Route::delete('/collections/{id}', [TabController::class, 'destroy']);
