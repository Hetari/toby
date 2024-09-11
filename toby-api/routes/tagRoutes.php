<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;

Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{id}', [TagController::class, 'index']);
Route::post('/tags', [TagController::class, 'store']);
Route::put('/tags/{id}', [TagController::class, 'update']);
Route::delete('/tags/{id}', [TagController::class, 'destroy']);
