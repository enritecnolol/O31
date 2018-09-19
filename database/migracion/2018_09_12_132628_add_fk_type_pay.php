<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkTypePay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facture', function (Blueprint $table) {
            $table->unsignedInteger('type_pay_id');

            $table->foreign('type_pay_id')->references('id')->on('type_pay');
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
        Schema::drop('type_pay');
    }
}
