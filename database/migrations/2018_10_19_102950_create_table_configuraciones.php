<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConfiguraciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreempresa');
            $table->string('telefono');
            $table->string('ciudad');
            $table->string('pais');
            $table->string('direccion');
            $table->string('img');
            $table->string('impuesto');
            $table->string('descuento');
            $table->string('controlinv');
            $table->string('emailinfo');
            $table->string('generacomprobante');
            $table->integer('config_clp_dn_part')->nullable($value = true);
            $table->integer('config_clp_punt_generar')->nullable($value = true);
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
        Schema::dropIfExists('configuracions');
    }
}
