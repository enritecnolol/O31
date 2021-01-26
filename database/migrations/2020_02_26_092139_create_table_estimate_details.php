<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEstimateDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('estimatedetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product')->nullable($value = true);
            $table->longText('description')->nullable($value = true);
            $table->integer('quantity');
            $table->float('price', 12,2);
            $table->integer('discount')->nullable($value = true);
            $table->float('amount', 12,2)->nullable($value = true);
            $table->integer('estimate_id')->nullable($value = true);
            $table->integer('product_id')->nullable($value = true);
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
        Schema::dropIfExists('estimatedetails');
    }
}
