<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInventoryAdjustments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('inventory_adjustments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('document');
            $table->date('date_document');
            $table->string('concept');
            $table->longText('note')->nullable($value = true);
            $table->float('total');
            $table->string('fit_type');
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
        Schema::dropIfExists('inventory_adjustments');
    }
}
