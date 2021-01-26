<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrdens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('ordens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mesa_id');
            $table->integer('num_invitado');
            $table->string('estado');
            $table->integer('subtotal');
            $table->string('camarero');
            $table->dateTime('fecha_apertura');
            $table->dateTime('fecha_cierre')->nullable($value = true);
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
        Schema::dropIfExists('ordens');
    }
}
