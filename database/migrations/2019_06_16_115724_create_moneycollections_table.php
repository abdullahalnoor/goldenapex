<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneycollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moneycollections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->Integer('customer_id')->unsigned();
            $table->float('due');
            $table->string('description')->nullable();
            $table->foreign('customer_id')->references('id')->on('customer_infos');
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
        Schema::dropIfExists('moneycollections');
    }
}
