<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
          
            $table->string('date');
            $table->string('sell_invoice_no');
            $table->string('others_bill')->nullable();
            $table->float('others_price')->nullable();
            $table->float('total_amount');
            $table->string('payment_type')->nullable();
            $table->float('total_discount')->nullable();
            $table->float('total_discount_two')->nullable();
            $table->text('invoice_details')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
