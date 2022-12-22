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
        Schema::create('Favorit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('favorite_customer');
            $table->unsignedBigInteger('favorite_product');

            $table->index('favorite_customer');
            $table->index('favorite_product');

            $table->foreign('favorite_customer', 'fk_favorite_customer')->references('id')->on('Customer')->onDelete('cascade');
            $table->foreign('favorite_product', 'fk_favorite_product')->references('product_id')->on('Product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Favorit');
    }
};
