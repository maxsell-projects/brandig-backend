<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Retorna o projeto pelo slug (ex: /api/project/cliente-1)
     */
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        return response()->json([
            'settings' => $project->settings
        ]);
    }

    /**
     * Salva ou Atualiza o projeto
     */
    public function store(Request $request, $slug)
    {
        // Aceita qualquer JSON na chave 'settings'
        $request->validate([
            'settings' => 'required|array',
        ]);

        $project = Project::updateOrCreate(
            ['slug' => $slug], // Busca por esse slug
            [
                'name' => $slug, // Usa o slug como nome por enquanto
                'settings' => $request->input('settings'), // Salva o JSON gigante
                'is_published' => true
            ]
        );

        return response()->json([
            'message' => 'Projeto salvo com sucesso!',
            'data' => $project
        ]);
    }

    /**
     * Faz upload de imagens e arquivos
     */
    public function upload(Request $request)
    {
        // Valida se é um arquivo de imagem ou PDF/ZIP, max 10MB
        $request->validate([
            'file' => 'required|file|max:10240', 
        ]);

        if ($request->hasFile('file')) {
            // Salva na pasta 'uploads' dentro do disco 'public'
            $path = $request->file('file')->store('uploads', 'public');

            // Retorna a URL completa para o Frontend usar
            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Nenhum arquivo enviado'], 400);
    }
}