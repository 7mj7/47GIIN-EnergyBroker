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
        Schema::create('tarifas_energia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('comercializadora_id')->constrained('comercializadoras')->restrictOnDelete();
            $table->foreignId('tarifa_acceso_id')->constrained('tarifas_acceso')->restrictOnDelete();
            $table->string('tipo_tarifa', 1) ;        // I = INDEXADA, F = FIJA
            $table->date('valida_desde')->nullable();
            $table->date('valida_hasta')->nullable();
            $table->boolean('activo')->default(true);
            // Precios de potencia (Electricidad)
            $table->decimal('pp_p1', 10, 6)->nullable();
            $table->decimal('pp_p2', 10, 6)->nullable();
            $table->decimal('pp_p3', 10, 6)->nullable();
            $table->decimal('pp_p4', 10, 6)->nullable();
            $table->decimal('pp_p5', 10, 6)->nullable();
            $table->decimal('pp_p6', 10, 6)->nullable(); 
            // Precios de energia (Electricidad)
            $table->decimal('pe_p1', 10, 6)->nullable();
            $table->decimal('pe_p2', 10, 6)->nullable();
            $table->decimal('pe_p3', 10, 6)->nullable();
            $table->decimal('pe_p4', 10, 6)->nullable();
            $table->decimal('pe_p5', 10, 6)->nullable();
            $table->decimal('pe_p6', 10, 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas_energia');
    }
};
