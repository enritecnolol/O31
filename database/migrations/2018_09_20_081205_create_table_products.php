<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price');
            $table->string('barcode')->unique();
            $table->string('img');
            $table->integer('existence')->nullable($value = true);
            $table->integer('impost')->nullable($value = true);
            $table->integer('status');
            $table->integer('impuestoref_id');
            $table->string('itbis');
            $table->string('compuesto');
            $table->integer('categoria_id');
            $table->integer('subcategoria_id')->nullable($value = true);
            $table->integer('user_id');
            $table->boolean('estado')->default(1);
            $table->boolean('sale_config')->nullable($value = true);;
            $table->boolean('service_config')->nullable($value = true);;
            $table->boolean('inventory_config')->nullable($value = true);;
            $table->boolean('purchase_config')->nullable($value = true);;
            $table->float('cost')->default(0.00);
            $table->longText('description')->nullable($value = true);;
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
        Schema::dropIfExists('products');
    }
}
