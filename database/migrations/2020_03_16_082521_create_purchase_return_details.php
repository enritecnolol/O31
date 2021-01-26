<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseReturnDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('purchase_returns_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->float('price',12,2);
            $table->float('itbis',12,2);
            $table->float('bruto',12,2);
            $table->float('total',12,2);
            $table->integer('purchase_return_id');
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
        Schema::dropIfExists('purchase_returns_details');
    }
}
