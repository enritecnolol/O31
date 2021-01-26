<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSuppliers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('rnc')->nullable($value = true);
            $table->string('contact')->nullable($value = true);
            $table->string('email')->nullable($value = true);
            $table->string('phone')->nullable($value = true);
            $table->text('observation')->nullable($value = true);
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
        Schema::dropIfExists('suppliers');
    }
}
