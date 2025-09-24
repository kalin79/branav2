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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('slug')->index();
            $table->string('icono')->nullable();
            $table->string('poster')->nullable();
            $table->string('poster_mobile')->nullable();
            $table->string('color')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('position')->default(0);
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('categorias');
    }
};
