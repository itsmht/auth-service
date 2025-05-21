<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\LoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Authentication routes
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('forgotPassword', [LoginController::class, 'forgotPassword']);
Route::post('resetPassword', [LoginController::class, 'resetPassword']);
Route::post('register', [RegistrationController::class, 'register']);
Route::post('updateAccount', [RegistrationController::class, 'updateAccount']);
Route::post('genreSelection', [RegistrationController::class, 'genreSelection']);
Route::post('verifyEmail', [VerificationController::class, 'verifyEmail']);
Route::post('verifyOTP', [VerificationController::class, 'verifyOTP']);
