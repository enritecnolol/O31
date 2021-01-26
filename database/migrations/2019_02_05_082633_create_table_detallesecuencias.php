<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetallesecuencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('detallesecuencias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serie');
            $table->string('tipo_nfc');
            $table->string('secuencia_inicial');
            $table->string('secuencia_final');
            $table->string('actual');
            $table->string('aviso');
            $table->integer('header_secuencia_id');
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
        Schema::dropIfExists('detallesecuencias');
    }
}
