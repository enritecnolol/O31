<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCaja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_apertura');
            $table->time('hora_apertura');
            $table->dateTime('fecha_cierre');
            $table->integer('almacen');
            $table->integer('valor_apertura');
            $table->integer('total_venta');
            $table->integer('total_cierre');
            $table->string('usuario');
            $table->string('status');
            $table->integer('caja_num');
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
        Schema::dropIfExists('cajas');
    }
}
