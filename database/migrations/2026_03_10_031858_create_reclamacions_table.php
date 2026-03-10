<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reclamacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('tipo_documento');
            $table->string('nro_documento');
            $table->string('nro_celular');
            $table->string('correo_electronico');
            $table->string('producto')->nullable();
            $table->string('nro_pedido')->nullable();
            $table->text('descripcion_bien')->nullable();
            $table->enum('tipo', ['reclamo', 'queja']);
            $table->text('detalle');
            $table->text('pedido');
            $table->boolean('tyc')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamacions');
    }
};
