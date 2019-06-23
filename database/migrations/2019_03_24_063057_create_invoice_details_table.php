<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->integer('product_id');
            $table->integer('inventory_id')->nullable();
            $table->integer('godown_id')->nullable();
            $table->integer('direct_sell')->nullable();
            $table->float('quantity');
            $table->float('rate');
            
            $table->float('total_price');	
            $table->float('discount',2)->nullable();
            $table->float('discount_two',2)->nullable();
            
            
         
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
        Schema::dropIfExists('invoice_details');
    }
}
