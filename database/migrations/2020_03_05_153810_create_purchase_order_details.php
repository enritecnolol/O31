<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('purchase_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->float('price',12,2);
            $table->float('itbis',12,2);
            $table->float('total',12,2);
            $table->integer('product_id');
            $table->integer('purchase_order_id');
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
        Schema::dropIfExists('purchase_order_details');
    }
}
