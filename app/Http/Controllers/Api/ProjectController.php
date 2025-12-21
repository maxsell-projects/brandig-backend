<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Project::select('id', 'name', 'slug', 'updated_at')->latest()->get()
        ]);
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        return response()->json([
            'settings' => $project->settings
        ]);
    }

    public function store(Request $request, $slug)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        $project = Project::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $slug,
                'settings' => $request->input('settings'),
                'is_published' => true
            ]
        );

        return response()->json([
            'message' => 'Projeto salvo com sucesso!',
            'data' => $project
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads', 'public');

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Nenhum arquivo enviado'], 400);
    }
}