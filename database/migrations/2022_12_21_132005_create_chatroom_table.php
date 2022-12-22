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
        Schema::create('Chatroom', function (Blueprint $table) {
            $table->id('Chatroom_id');
            $table->unsignedBigInteger('Chatroom_customer');
            $table->unsignedBigInteger('Chatroom_shop');
            $table->index('Chatroom_customer');
            $table->index('Chatroom_shop');
            $table->foreign('Chatroom_customer', 'fk_chatroom_customer')->references('id')->on('Customer')->onDelete('cascade');
            $table->foreign('Chatroom_shop', 'fk_chatroom_shop')->references('id')->on('Shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Chatroom');
    }
};
