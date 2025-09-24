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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->index()->nullable();
            $table->string('title_small')->nullable();
            $table->string('title_large')->nullable();
            $table->string('slug')->unique()->index();
            $table->integer('categoria_id')->nullable()->index();
            $table->text('description')->nullable();
            $table->text('description_small')->nullable();
            $table->string('presentacion')->nullable();
            $table->string('poster')->nullable();
            $table->string('poster_mobile')->nullable();
            $table->string('condiciones')->nullable();
            $table->decimal('precio_normal',10,2)->nullable();
            $table->decimal('precio_online',10,2)->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('active')->default(true);

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
        Schema::dropIfExists('productos');
    }
};
