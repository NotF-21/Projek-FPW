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
        Schema::create('Promo_Global', function (Blueprint $table) {
            $table->id('promo_global_id');
            $table->string('promo_global_name',256);
            $table->integer('promo_global_amount');
            $table->unsignedBigInteger('promo_global_type');
            $table->unsignedBigInteger('promo_global_sourceadmin');
            $table->date('promo_global_expiredate');
            $table->tinyInteger('promo_global_status')->default(1);
            $table->timestamps();

            $table->index('promo_global_type');
            $table->index('promo_global_sourceadmin');

            $table->foreign('promo_global_type', 'fk_pg_type')->references('promo_type_id')->on('Promo_Type')->onDelete('cascade');
            $table->foreign('promo_global_sourceadmin', 'fk_pg_admin')->references('id')->on('Admin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Promo_Global');
    }
};
