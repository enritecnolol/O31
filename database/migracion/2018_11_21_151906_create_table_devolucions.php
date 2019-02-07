<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDevolucions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucions', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('client')->nullable($value = true);
            $table->float('brute');
            $table->float('itbis');
            $table->integer('total_devolucion');
            $table->integer('Monto_efectivo')->nullable($value = true);
            $table->integer('factura_id');
            $table->integer('caja_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('devolucions');
    }
}
