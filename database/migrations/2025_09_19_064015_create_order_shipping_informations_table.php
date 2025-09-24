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
        Schema::create('order_shipping_informations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('nro_documento')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('direction')->nullable();
            $table->string('reference')->nullable();
            $table->integer('district_id')->nullable();
            $table->decimal('delivery',10,2)->nullable();
            $table->string('postal_code')->nullable();
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
        Schema::dropIfExists('order_shipping_informations');
    }
};
