<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetailsOrdens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_ordens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orden_id');
            $table->integer('product_id');
            $table->integer('cantidad');
            $table->float('itbis');
            $table->float('bruto');
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
        Schema::dropIfExists('details_ordens');
    }
}
