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
        Schema::create('Voucher_Customer', function (Blueprint $table) {
            $table->id('voucher_customer_id');
            $table->unsignedBigInteger('voucher_customer_customer');
            $table->unsignedBigInteger('voucher_customer_voucher');

            $table->index('voucher_customer_customer');
            $table->index('voucher_customer_voucher');

            $table->foreign('voucher_customer_customer', 'fk_vc_customer')->references('id')->on('Customer')->onDelete('cascade');
            $table->foreign('voucher_customer_voucher', 'fk_vc_voucher')->references('voucher_id')->on('Voucher')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Voucher_Customer');
    }
};
