<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_return_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sell_return_id');
            $table->integer('product_id');
            $table->integer('sell_return_qty');
            $table->integer('location_id')->nullable();
            $table->integer('godown_id')->nullable();
            $table->integer('direct_sell')->nullable();
            $table->double('price',2);
            $table->double('total',2);
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
        Schema::dropIfExists('sell_return_details');
    }
}
