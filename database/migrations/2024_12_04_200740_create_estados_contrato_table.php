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
        Schema::create('estados_contrato', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 15)->unique(); // Hacer el nombre único y máximo 15 caracteres
            $table->text('descripcion')->nullable(); // Campo de descripción
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_contrato');
    }
};
