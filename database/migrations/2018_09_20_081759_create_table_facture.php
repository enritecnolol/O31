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
        Schema::create('factures', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('box');
            $table->integer('cashier');
            $table->string('client')->nullable($value = true);
            $table->float('brute');
            $table->float('desc');
            $table->float('itbis');
            $table->integer('total_facture');
            $table->integer('Monto_tarjeta')->nullable($value = true);
            $table->integer('Monto_efectivo')->nullable($value = true);
            $table->integer('returns')->nullable($value = true);
            $table->integer('puntos')->nullable($value = true);
            $table->integer('ticket_id')->nullable($value = true);
            $table->string('status');
            $table->string('type_sale');
            $table->string('type_tarject')->nullable($value = true);
            $table->string('Numbertar')->nullable($value = true);
            $table->string('Banco')->nullable($value = true);
            $table->string('auth')->nullable($value = true);
            $table->string('tipo_nfc')->nullable($value = true);
            $table->string('nfc')->nullable($value = true);
            $table->string('telefono_nfc')->nullable($value = true);
            $table->string('rnc_nfc')->nullable($value = true);
            $table->string('razon_nfc')->nullable($value = true);
            $table->float('leycamarero', 8, 2)->nullable($value = true);
            $table->date('due_date')->nullable($value = true);
            $table->longText('address')->nullable($value = true);
            $table->longText('note')->nullable($value = true);
            $table->string('email')->nullable($value = true);
            $table->float('open_balance', 8, 2)->nullable($value = true);
            $table->string('paid_status')->nullable($value = true);
            $table->integer('caja_id');
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
        Schema::dropIfExists('factures');
    }
}
