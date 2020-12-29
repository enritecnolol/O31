<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProvedors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('provedors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('razon_social')->nullable($value = true);
            $table->longText('direccion');
            $table->string('pais');
            $table->string('provincia');
            $table->string('ciudad');
            $table->string('sector');
            $table->string('telefono');
            $table->string('email');
            $table->string('contacto')->nullable($value = true);
            $table->string('itbis');
            $table->string('tcontribuyente')->nullable($value = true);
            $table->string('referencia')->nullable($value = true);
            $table->string('cedula');
            $table->string('vendedor');
            $table->integer('Condiciones');
            $table->integer('tcxp_id');
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
        Schema::dropIfExists('provedors');
    }
}
