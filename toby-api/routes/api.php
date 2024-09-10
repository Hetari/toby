<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
require base_path('routes/authRoutes.php');


Route::middleware(['isAuthenticated'])->group(function () {
    // collections api
});
