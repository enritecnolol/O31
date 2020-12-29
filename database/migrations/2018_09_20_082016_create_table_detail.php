<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('details', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->string('name_product');
            $table->float('descuento');
            $table->float('quanlity');
            $table->float('price');
            $table->float('depot');
            $table->float('impost');
            $table->integer('product_id');
            $table->integer('facture_id');
            $table->longText('description')->nullable($value = true);;
            $table->integer('invoice_id')->nullable($value = true);;
            $table->float('amount', 12,2)->nullable($value = true);;
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
        Schema::dropIfExists('details');
    }
}
