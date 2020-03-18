<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('document_no');
            $table->integer('supplier_id');
            $table->string('invoice')->nullable($value = true);
            $table->string('ncf')->nullable($value = true);
            $table->string('purchase_order')->nullable($value = true);
            $table->date('invoice_date');
            $table->integer('term_id')->nullable($value = true);
            $table->longText('note')->nullable($value = true);
            $table->float('subtotal', 12,2);
            $table->float('itbis', 12,2);
            $table->float('total', 12,2);
            $table->boolean('status');
            $table->float('balance', 12,2);
            $table->string('payment_status ');
            $table->string('kind_purchase');
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
        Schema::dropIfExists('purchases');
    }
}
