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
        Schema::create('Review', function (Blueprint $table) {
            $table->id('review_id');
            $table->integer('review_rating');
            $table->string('review_review', 256)->nullable();
            $table->unsignedBigInteger('review_shop');
            $table->unsignedBigInteger('review_customer');
            $table->index('review_shop');
            $table->index('review_customer');
            $table->foreign('review_customer', 'fk_review_customer')->references('id')->on('Customer')->onDelete('cascade');
            $table->foreign('review_shop', 'fk_review_shop')->references('id')->on('Shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Review');
    }
};
