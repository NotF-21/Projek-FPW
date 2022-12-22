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
        Schema::create('Product', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name',256);
            $table->integer('product_price');
            $table->string('product_desc', 500);
            $table->integer('product_stock');
            $table->string('product_img', 256)->nullable();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('shop_id');
            $table->timestamp('deleted_at')->nullable();

            $table->index('type_id');
            $table->index('shop_id');

            $table->foreign('type_id', 'fk_product_type')->references('id')->on('Product_Type')->onDelete('cascade');
            $table->foreign('shop_id', 'fk_product_shop')->references('id')->on('Shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Product');
    }
};
