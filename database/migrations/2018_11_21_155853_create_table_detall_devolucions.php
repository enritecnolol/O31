<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetallDevolucions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('detalle_devolucions', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->string('name_product')->nullable($value = true);
            $table->float('quanlity');
            $table->integer('price');
            $table->float('itbis');
            $table->float('bruto');
            $table->integer('product_id');
            $table->integer('devolucion_id');
            $table->integer('user_id');
            $table->longText('description')->nullable($value = true);
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
        Schema::dropIfExists('detalle_devolucions');
    }
}
