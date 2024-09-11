<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tagController;

Route::get('/tags', [tagController::class, 'index']);
Route::get('/tags/{id}', [tagController::class, 'index']);
Route::post('/tags', [tagController::class, 'store']);
Route::put('/tags/{id}', [tagController::class, 'update']);
Route::delete('/tags/{id}', [tagController::class, 'destroy']);
