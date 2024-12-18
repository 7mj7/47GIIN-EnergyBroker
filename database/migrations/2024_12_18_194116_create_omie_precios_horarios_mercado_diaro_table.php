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
        Schema::create('omie_precios_horarios_mercado_diaro', function (Blueprint $table) {
            $table->id();
            $table->integer('anio');
            $table->integer('mes');
            $table->integer('dia');
            $table->integer('hora');
            $table->float('marginalPT', 8, 2);
            $table->float('marginalES', 8, 2);
            $table->timestamps();

            // Añadir un índice único para año, mes, día y hora
            $table->unique(['anio', 'mes', 'dia', 'hora']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('omie_precios_marginales_horarios');
    }
};
