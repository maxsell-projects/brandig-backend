<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;

// Rotas da nossa API
Route::post('/upload', [ProjectController::class, 'upload']);
Route::get('/project/{slug}', [ProjectController::class, 'show']);
Route::post('/project/{slug}', [ProjectController::class, 'store']);