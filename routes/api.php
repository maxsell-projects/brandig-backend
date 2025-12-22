<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\AuthController;

// --- Rotas Públicas ---
// Login
Route::post('/login', [AuthController::class, 'login']);
// Cliente ver o projeto (Qualquer um com o link acessa)
Route::get('/project/{slug}', [ProjectController::class, 'show']);

// --- Rotas Protegidas (Só Logado) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);
    
    // Upload de arquivos
    Route::post('/upload', [ProjectController::class, 'upload']);
    
    // Salvar/Atualizar Projeto
    Route::post('/project/{slug}', [ProjectController::class, 'store']);
    
    // Listar todos os projetos (Dashboard)
    Route::get('/projects', [ProjectController::class, 'index']);

    // Excluir Projeto (NOVA ROTA)
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
});