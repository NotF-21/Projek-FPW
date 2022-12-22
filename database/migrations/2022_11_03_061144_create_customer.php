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
        Schema::create('Customer', function (Blueprint $table) {
            $table->id('id');
            $table->string('customer_username', 256);
            $table->string('customer_password', 256);
            $table->string('customer_name', 256);
            $table->string('customer_phonenumber', 256);
            $table->string('customer_address',256);
            $table->string('customer_gender', 10);
            $table->string('customer_accountnumber', 256);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
};
