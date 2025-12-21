<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Libera esses campos para serem salvos
    protected $fillable = [
        'slug',
        'name',
        'settings',
        'is_published'
    ];

    // OBRIGATÓRIO: Diz pro Laravel converter o JSON para Array e vice-versa
    protected $casts = [
        'settings' => 'array', 
        'is_published' => 'boolean',
    ];
}