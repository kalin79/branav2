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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_id')->index();
            $table->bigInteger('product_id')->index();
            $table->string('product_name')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->integer('price_type')->default(0)->comment('0:OnLine;1:Partner');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->integer('status')->nullable();
            $table->text('detail')->nullable();
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
        Schema::dropIfExists('sale_products');
    }
};
