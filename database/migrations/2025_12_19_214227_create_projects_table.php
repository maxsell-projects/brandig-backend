<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // Identificador único (ex: 'cliente-x')
            $table->string('name'); // Nome legível do projeto
            $table->json('settings'); // AQUI: Guarda todo o JSON do BrandStore
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }
};
