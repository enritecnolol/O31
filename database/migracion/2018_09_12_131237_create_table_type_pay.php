<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTypePay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_pay', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('num_tarjeta');
            $table->integer('chash');
            $table->integer('return');
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
        Schema::drop('type_pay');
    }
}
