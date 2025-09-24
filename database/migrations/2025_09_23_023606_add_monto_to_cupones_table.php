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
        Schema::table('cupones', function (Blueprint $table) {
            $table->integer('tipo')->nullable()->after('usuario_asociado');
            $table->decimal('monto',10,2)->default(0)->after('tipo');
            $table->integer('estado')->default(1)->after('monto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cupones', function (Blueprint $table) {
            $table->dropColumn('monto');
            $table->dropColumn('estado');
        });
    }
};
