<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFacture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('box');
            $table->integer('cashier');
            $table->string('client');
            $table->integer('brute');
            $table->integer('desc');
            $table->integer('itbis');
            $table->integer('total_facture');
            $table->integer('Monto_tarjeta');
            $table->integer('Monto_efectivo');
            $table->integer('returns');
            $table->string('status');
            $table->string('type_sale');
            $table->string('type_tarject');
            $table->string('Numbertar');
            $table->string('Banco');
            $table->string('auth');
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
        Schema::dropIfExists('factures');
    }
}
