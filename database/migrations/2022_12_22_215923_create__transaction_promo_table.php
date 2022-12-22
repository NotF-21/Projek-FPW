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
        Schema::create('Transaction_Promo', function (Blueprint $table) {
            $table->id('tp_id');
            $table->string('invoice_number');
            $table->unsignedBigInteger('promo_id');

            $table->index('invoice_number');
            $table->index('promo_id');

            $table->foreign('promo_id', 'fk_trnas_promo')->references('promo_id')->on('Promo')->onDelete('cascade');
            $table->foreign('invoice_number', 'fk_invoice_promo')->references('invoice_number')->on('H_Trans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Transaction_Promo');
    }
};
