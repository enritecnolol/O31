<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePagoComprobante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagocomprobantes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('entradacomprobante_id');
            $table->integer('balance');
            $table->integer('montopagado');
            $table->integer('suplidor_id');
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
        Schema::dropIfExists('pagocomprobantes');
    }
}
