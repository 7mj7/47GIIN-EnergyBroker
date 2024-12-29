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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();

            // Datos Generales
            //$table->foreignId('estado_id')->constrained()->restrictOnDelete();
            $table->foreignId('estado_contrato_id')
                ->nullable()
                ->constrained('estados_contrato')
                ->nullOnDelete();
            $table->date('fecha_estado')->nullable();

            // Códigos de Tercero y de Suministro
            $table->foreignId('tercero_id')->constrained()->restrictOnDelete();
            $table->foreignId('suministro_id')->constrained()->restrictOnDelete();

            // Titular
            $table->string('nif_titular', 15)->nullable();
            $table->string('nombre_titular');
            $table->string('telefono1', 30)->nullable();
            $table->string('telefono2', 30)->nullable();
            $table->string('email')->nullable();
            // Suministro
            $table->string('cups', 20);
            $table->string('tarifa_acceso', 15);
            $table->integer('consumo_anual')->nullable(); // Añadir el campo entero para el consumo
            $table->string('direccion');
            $table->string('codigo_postal', 5);
            $table->string('poblacion');
            $table->string('provincia');
            // Tarifa
            $table->foreignId('comercializadora_id')->constrained()->restrictOnDelete();
            $table->foreignId('tarifa_energia_id')->constrained('tarifas_energia')->restrictOnDelete();
            $table->date('fecha_firma')->nullable();
            $table->date('fecha_activacion')->nullable();
            $table->date('fecha_baja')->nullable();

            // Cuenta Bancaria            
            $table->string('iban', 34)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
