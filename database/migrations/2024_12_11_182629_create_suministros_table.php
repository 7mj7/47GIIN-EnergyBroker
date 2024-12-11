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
        Schema::create('suministros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tercero_id')->constrained()->restrictOnDelete();
            $table->string('cups',20);
            $table->foreignId('tarifa_acceso_id')->constrained('tarifas_acceso')->restrictOnDelete();
            $table->integer('consumo_anual')->nullable(); // Añadir el campo entero para el consumo
            $table->string('direccion');
            $table->string('codigo_postal',5);
            $table->string('poblacion');
            $table->string('provincia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suministros');
    }
};
