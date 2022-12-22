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
        Schema::create('Shop', function (Blueprint $table) {
            $table->id();
            $table->string('shop_username', 256);
            $table->string('shop_password', 256);
            $table->string('shop_name', 256);
            $table->string('shop_emailaddress', 256);
            $table->string('shop_phonenumber', 256);
            $table->string('shop_accountnumber', 256);
            $table->string('shop_address', 256);
            $table->tinyInteger('shop_status')->default(2)->comment('1 -> active, 0 -> nonactive, 2 -> waiting_list');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Shop');
    }
};
