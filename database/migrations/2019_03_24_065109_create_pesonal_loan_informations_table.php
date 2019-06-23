<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesonalLoanInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesonal_loan_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id');
            $table->string('person_name');
            $table->string('person_phone');
            $table->text('person_address');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('pesonal_loan_informations');
    }
}
