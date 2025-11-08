<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\Auth\AuthenticateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API is working'], 200);
});

Route::post('/register', [AuthenticateController::class, 'register']);
Route::post('/login', [AuthenticateController::class, 'login']);
Route::post('/feed/store', [FeedController::class, 'store'])->middleware('auth:sanctum');
