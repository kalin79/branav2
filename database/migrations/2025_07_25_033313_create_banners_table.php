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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('poster')->nullable();
            $table->string('poster_mobile')->nullable();
            $table->string('button')->nullable();
            $table->string('link')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('active')->default(true);
            $table->integer('abrir_otra_ventana')->default(0);
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
        Schema::dropIfExists('banners');
    }
};
