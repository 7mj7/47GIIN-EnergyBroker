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
            $table->foreignId('tercero_id')->constrained()->restrictOnDelete();
            $table->foreignId('suministro_id')->constrained()->restrictOnDelete();
            $table->string('nif_titular',15)->nullable();
            $table->string('nombre_titular');
            $table->string('telefono1',30)->nullable();
            $table->string('telefono2',30)->nullable();
            $table->string('email')->nullable();
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
