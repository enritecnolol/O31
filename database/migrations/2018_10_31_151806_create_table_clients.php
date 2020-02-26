<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('email');
            $table->string('matricula');
            $table->longText('observacion')->nullable($value = true);
            $table->integer('puntos')->nullable($value = true);
            $table->integer('descuento')->nullable($value = true);
            $table->longText('direccion')->nullable($value = true);
            $table->string('direccion')->nullable($value = true);
            $table->float('limit_balance', 12,2)->nullable($value = true);
            $table->integer('term')->nullable($value = true);
            $table->string('contact')->nullable($value = true);
            $table->integer('tarjeta_id');
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
        Schema::dropIfExists('clients');
    }
}
