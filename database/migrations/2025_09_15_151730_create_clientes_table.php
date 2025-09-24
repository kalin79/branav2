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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('tipo_documento')->index()->nullable();
            $table->string('nro_documento')->index()->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->index()->nullable();
            $table->text('direccion')->nullable();
            $table->string('password');
            $table->integer('departamento_id')->nullable();
            $table->integer('provincia_id')->nullable();
            $table->integer('distrito_id')->nullable();
            $table->integer('active')->default(1);
            $table->integer('tyc')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->integer('deleted_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
