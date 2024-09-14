<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollectionController;

// Route::get('/collections/{id?}', [CollectionController::class, 'index']);
// Route::post('/collections', [CollectionController::class, 'store']);
// Route::put('/collections/{id}', [CollectionController::class, 'update']);
// Route::delete('/collections/{id}', [CollectionController::class, 'destroy']);

// Define API resource routes for collections
Route::resource('collections', CollectionController::class);