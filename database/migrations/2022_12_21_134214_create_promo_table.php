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
        Schema::create('Promo', function (Blueprint $table) {
            $table->id('promo_id');
            $table->string('promo_name',256);
            $table->integer('promo_amount');
            $table->unsignedBigInteger('promo_type');
            $table->unsignedBigInteger('promo_sourceshop');
            $table->date('promo_expiredate');
            $table->tinyInteger('promo_status')->default(1);

            $table->index('promo_type');
            $table->index('promo_sourceshop');

            $table->foreign('promo_type', 'fk_promo_type')->references('promo_type_id')->on('Promo_Type')->onDelete('cascade');
            $table->foreign('promo_sourceshop', 'fk_promo_shop')->references('id')->on('Shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Promo');
    }
};
