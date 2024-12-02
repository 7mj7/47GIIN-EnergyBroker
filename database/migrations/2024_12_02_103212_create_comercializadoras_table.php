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
        Schema::create('comercializadoras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',15)->unique();
            $table->boolean('activo')->default(true);            
            $table->string('nombre_fiscal')->nullable();
            $table->string('cif', 15)->nullable();  // El CIF español tiene 9 caracteres
            $table->string('gestor_nombre')->nullable();
            $table->string('gestor_telefono', 15)->nullable();
            $table->string('gestor_email')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercializadoras');
    }
};
