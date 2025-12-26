<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/project/{slug}', [ProjectController::class, 'show']);

Route::get('/public-file/{path}', function ($path) {
    $path = urldecode($path);
    
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->path($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::file($file, [
        'Content-Type' => $type,
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
    ]);
})->where('path', '.*');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);
    
    Route::post('/upload', [ProjectController::class, 'upload']);
    
    Route::post('/project/{slug}', [ProjectController::class, 'store']);
    
    Route::get('/projects', [ProjectController::class, 'index']);

    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
});