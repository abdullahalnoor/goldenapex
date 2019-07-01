<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cfts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grade_id');
            $table->integer('width');
            $table->integer('height');
            $table->integer('length');
            $table->double('rate',30,2);
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
        Schema::dropIfExists('product_cfts');
    }
}
