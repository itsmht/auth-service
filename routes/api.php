<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [RegistrationController::class, 'register']);
Route::post('updateAccount', [RegistrationController::class, 'updateAccount']);
Route::post('genreSelection', [RegistrationController::class, 'genreSelection']);

