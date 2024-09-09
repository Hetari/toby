<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::post("/register", [AuthController::class, 'register'])->name("register");
Route::post("/login", [AuthController::class, 'login'])->name("login");

Route::middleware(['isAuthenticated'])->group(function () {
    Route::post("/test", [AuthController::class, 'test'])->name("test");
});
