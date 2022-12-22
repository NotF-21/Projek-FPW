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
        Schema::create('Voucher', function (Blueprint $table) {
            $table->id('voucher_id');
            $table->string('voucher_name',256);
            $table->integer('voucher_amount');
            $table->unsignedBigInteger('voucher_type');
            $table->unsignedBigInteger('voucher_sourceadmin');
            $table->date('voucher_expiredate');
            $table->tinyInteger('voucher_status')->default(1);

            $table->index('voucher_type');
            $table->index('voucher_sourceadmin');

            $table->foreign('voucher_type', 'fk_voucher_admin')->references('promo_type_id')->on('Promo_Type')->onDelete('cascade');
            $table->foreign('voucher_sourceadmin', 'fk_voucher_type')->references('id')->on('Admin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Voucher');
    }
};
