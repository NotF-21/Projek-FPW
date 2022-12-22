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
        Schema::create('D_Trans', function (Blueprint $table) {
            $table->id('dtrans_id');
            $table->string('invoice_number', 256);
            $table->unsignedBigInteger('product_id');
            $table->integer('product_number');

            $table->index('invoice_number');
            $table->index('product_id');

            $table->foreign('product_id', 'fk_trans_product')->references('product_id')->on('Product')->onDelete('cascade');
            $table->foreign('invoice_number', 'fk_dtrans')->references('invoice_number')->on('H_Trans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('D_Trans');
    }
};
