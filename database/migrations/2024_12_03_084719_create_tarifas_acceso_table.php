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
        Schema::create('tarifas_acceso', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_energia', 1) ;  // Guarda 'E' para Electricidad, 'G' para Gas
            $table->string('nombre', 15)->unique();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Agrega la restricción de unicidad compuesta para tipo_energia_id y nombre
            $table->unique(['tipo_energia', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas_acceso');
    }
};
