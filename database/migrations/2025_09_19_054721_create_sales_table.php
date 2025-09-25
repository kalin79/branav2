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
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->index();
            $table->bigInteger('client_address_id')->index()->nullable();
            $table->bigInteger('payment_method_id')->index()->nullable();
            $table->integer('type')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->date('date_send')->nullable();
            $table->time('hour_range')->nullable();
            $table->string('order_number')->index()->nullable();
            $table->integer('quantity_products')->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('cost_delivery_district', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('how_much_pay', 10, 2)->default(0);
            $table->char('voucher', 3)->nullable();
            $table->integer('tipo_voucher_id')->nullable();
            $table->string('ruc', 11)->nullable();
            $table->string('razon_social', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('phone', 200)->nullable();
            $table->text('direccion')->nullable();
            $table->string('contact_cell_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_name')->nullable();
            $table->integer('status_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_result')->nullable();
            $table->string('transaction_status')->nullable();
            $table->integer('status_pay')->nullable();
            $table->string('codigo_descuento')->nullable();
            $table->text('comments')->nullable();
            $table->text('discount_info')->nullable();
            $table->integer('tyc')->nullable();
            $table->integer('politica_privacidad')->nullable();
            $table->integer('enviar_correo_ofertas')->nullable();
            $table->integer('tienda_id')->nullable();
            $table->integer('order_shipping_information_id')->nullable();
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
        Schema::dropIfExists('sales');
    }
};
