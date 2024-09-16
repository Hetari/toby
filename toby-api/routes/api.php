<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TabController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
require base_path('routes/authRoutes.php');


Route::middleware(['isAuthenticated'])->group(function () {
    Route::get('/search', [SearchController::class, 'search']);

    // Routes for TagController
    Route::get('/tags', [TagController::class, 'index']); // Get all tags
    Route::post('/tags', [TagController::class, 'store']); // Create a new tag
    Route::get('/tags/{id}', [TagController::class, 'index']); // Get a specific tag by ID
    Route::put('/tags/{id}', [TagController::class, 'update']); // Update a tag by ID
    Route::delete('/tags/{id}', [TagController::class, 'destroy']); // Delete a tag by ID

    // Routes for TabController
    Route::get('/tabs', [TabController::class, 'index']); // Get all tabs
    Route::post('/tabs', [TabController::class, 'store']); // Create a new tab
    Route::get('/tabs/{id}', [TabController::class, 'index']); // Get a specific tab by ID
    Route::put('/tabs/{id}', [TabController::class, 'update']); // Update a tab by ID
    Route::delete('/tabs/{id}', [TabController::class, 'destroy']); // Delete a tab by ID

    // Routes for CollectionController
    Route::get('/collections/{id?}', [CollectionController::class, 'index']); // Get all collections
    Route::post('/collections', [CollectionController::class, 'store']); // Create a new collection
    Route::put('/collections/{id}', [CollectionController::class, 'update']); // Update a collection by ID
    Route::delete('/collections/{id}', [CollectionController::class, 'destroy']); // Delete a collection by ID
});
