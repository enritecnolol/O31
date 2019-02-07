<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEntradacomprobantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradacomprobantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tiponcf_id');
            $table->integer('tipofactura_id');
            $table->integer('suplidor_id');
            $table->string('emisiorrnc')->nullable($value = true);
            $table->string('emisiorfactura')->nullable($value = true);
            $table->string('factura_ref');
            $table->date('date');
            $table->string('ncf')->nullable($value = true);
            $table->string('tipogasto');
            $table->string('condiciones')->nullable($value = true);
            $table->string('concepto')->nullable($value = true);
            $table->string('formaapgo');
            $table->float('subtotal');
            $table->float('descuento');
            $table->float('itbispagado');
            $table->float('flete')->nullable($value = true);
            $table->float('netototal');
            $table->float('balance');
            $table->integer('montoapagar');
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
        Schema::dropIfExists('entradacomprobantes');
    }
}
