<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facture', function (Blueprint $table) {

            $table->unsignedInteger('detail_id');

            $table->foreign('detail_id')->references('id')->on('detail');
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
        Schema::drop('detail');
    }
}
