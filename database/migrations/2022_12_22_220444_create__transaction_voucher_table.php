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
        Schema::create('Transaction_Voucher', function (Blueprint $table) {
            $table->id('tv_id');
            $table->string('invoice_number');
            $table->unsignedBigInteger('voucher_id');

            $table->index('invoice_number');
            $table->index('voucher_id');

            $table->foreign('voucher_id', 'fk_tv_voucher')->references('voucher_customer_id')->on('Voucher_Customer')->onDelete('cascade');
            $table->foreign('invoice_number', 'fk_invoice_voucher')->references('invoice_number')->on('H_Trans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Transaction_Voucher');
    }
};
