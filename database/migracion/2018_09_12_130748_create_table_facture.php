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
        Schema::create('facture', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date');
            $table->integer('box');
            $table->integer('cashier');
            $table->string('client');
            $table->integer('brute');
            $table->integer('desc');
            $table->integer('itbis');
            $table->integer('total_facture');
            $table->string('status');
            $table->string('type_sale');
            $table->integer('impost');

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
        Schema::drop('facture');
    }
}
