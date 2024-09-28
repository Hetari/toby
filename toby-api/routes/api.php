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


// Route::middleware(['isAuthenticated'])->group(function () {
// require base_path('routes/tagRoutes.php');
// require base_path('routes/tabRoutes.php');
// });
// Route::resource('tabs', TabController::class);
// Route::resource('tags', TagController::class);
require base_path('routes/collectionRoutes.php');
require base_path('routes/tabRoutes.php');
require base_path('routes/tagRoutes.php');
