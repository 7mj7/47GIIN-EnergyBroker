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
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->string('grupo');     // Grupo de la configuración (general, correo, etc.)
            $table->string('nombre');    // Nombre de la configuración
            $table->text('valor');       // Valor de la configuración (puede ser JSON, texto, etc.)
            $table->timestamps();

            // Añadir índice único a la combinación de 'grupo' y 'nombre'
            $table->unique(['grupo', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros');
    }
};
