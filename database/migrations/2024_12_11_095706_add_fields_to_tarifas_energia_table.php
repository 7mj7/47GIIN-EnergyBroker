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
        Schema::table('tarifas_energia', function (Blueprint $table) {
            $table->decimal('tf', 10, 6)->nullable(); # termino fijo de gas
            $table->decimal('tv', 10, 6)->nullable(); # termino variable de gas
            $table->decimal('rem_index', 10, 6)->nullable(); # Remuneración / GO para las tarifas Indexadas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarifas_energia', function (Blueprint $table) {
            $table->dropColumn('tf');
            $table->dropColumn('tv');
            $table->dropColumn('rem_index');
        });
    }
};
