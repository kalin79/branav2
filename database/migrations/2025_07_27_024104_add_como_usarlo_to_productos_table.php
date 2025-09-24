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
        Schema::table('productos', function (Blueprint $table) {
            $table->text('acerca_producto')->after('description_small')->nullable();
            $table->string('imagen_acerca_producto')->after('acerca_producto')->nullable();
            $table->text('como_usarlo')->after('imagen_acerca_producto')->nullable();
            $table->string('imagen_como_usarlo')->after('como_usarlo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('acerca_producto');
            $table->dropColumn('como_usarlo');
            $table->dropColumn('imagen_acerca_producto');
            $table->dropColumn('imagen_como_usarlo');
        });
    }
};
