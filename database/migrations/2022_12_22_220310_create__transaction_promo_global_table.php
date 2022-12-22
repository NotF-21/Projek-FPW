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
        Schema::create('Transaction_PromoGlobal', function (Blueprint $table) {
            $table->id('tpg_id');
            $table->string('invoice_number');
            $table->unsignedBigInteger('promo_global_id');

            $table->index('invoice_number');
            $table->index('promo_global_id');

            $table->foreign('promo_global_id', 'fk_tpg_promoglobal')->references('promo_global_id')->on('Promo_Global')->onDelete('cascade');
            $table->foreign('invoice_number', 'fk_invoice_promoglobal')->references('invoice_number')->on('H_Trans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Transaction_PromoGlobal');
    }
};
