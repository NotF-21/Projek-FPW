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
        Schema::create('Chat', function (Blueprint $table) {
            $table->id('chat_id');
            $table->string('chat_content', 256);
            $table->string('chat_sender',256);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->unsignedBigInteger('room_id');
            $table->index('room_id');
            $table->foreign('room_id', 'fk_chat_room')->references('Chatroom_id')->on('Chatroom')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Chat');
    }
};
