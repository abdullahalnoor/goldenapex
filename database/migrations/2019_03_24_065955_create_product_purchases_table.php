<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('challan_no')->nullable();
            $table->integer('supplier_id');
            $table->integer('purchase_invoice_no');
            $table->float('grand_total_amount');
            $table->float('total_discount');
            $table->string('purchase_date');
            $table->string('payment_type')->nullable();
            $table->text('purchase_details');
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
        Schema::dropIfExists('product_purchases');
    }
}
