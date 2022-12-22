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
        Schema::create('switch', function (Blueprint $table) {
            $table->id('switch_id');
            $table->unsignedBigInteger('switch_customer_1');
            $table->unsignedBigInteger('switch_customer_2');
            $table->index('switch_customer_1');
            $table->index('switch_customer_2');
            $table->foreign('switch_customer_1', 'fk_switch_customer_1')->references('id')->on('Customer')->onDelete('cascade');
            $table->foreign('switch_customer_2', 'fk_switch_customer_2')->references('id')->on('Customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('switch');
    }
};
