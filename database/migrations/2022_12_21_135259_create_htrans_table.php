<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('H_Trans', function (Blueprint $table) {
            $table->string('invoice_number', 256)->primary();
            $table->dateTime('trans_date');
            $table->integer('trans_total');
            $table->unsignedBigInteger('trans_customer');
            $table->string('trans_token', 256)->nullable();
            $table->string('payment_status', 256)->nullable();
            $table->string('order_status', 256)->nullable();
            $table->string('shipping_address', 256);

            $table->index('trans_customer');

            $table->foreign('trans_customer', 'fk_transaction_customer')->references('id')->on('Customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('H_Trans');
    }
};
