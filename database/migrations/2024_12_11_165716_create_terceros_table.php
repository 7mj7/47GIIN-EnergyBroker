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
        Schema::create('terceros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('nif',15)->nullable();
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('codigo_postal',5)->nullable();
            $table->string('poblacion')->nullable();
            $table->string('provincia')->nullable();
            $table->string('telefono1')->nullable();
            $table->string('telefono2')->nullable();
            $table->string('email')->nullable();
            $table->string('contacto')->nullable();
            $table->text('notas')->nullable();                                    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terceros');
    }
};
