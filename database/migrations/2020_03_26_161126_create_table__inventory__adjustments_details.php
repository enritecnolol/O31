<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInventoryAdjustmentsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('inventory_adjustments_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->float('amount');
            $table->integer('inventory_adjustments_id');
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
        Schema::dropIfExists('inventory_adjustments_details');
    }
}
