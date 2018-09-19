<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->string('name_product');
            $table->integer('unity_sale');
            $table->integer('quanlity');
            $table->integer('price');
            $table->integer('depot');
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
        Schema::drop('detail');
    }
}
