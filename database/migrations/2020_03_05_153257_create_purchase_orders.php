<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('document_no');
            $table->integer('supplier_id');
            $table->string('invoice')->nullable($value = true);
            $table->string('ncf')->nullable($value = true);
            $table->string('purchase_order')->nullable($value = true);
            $table->date('invoice_date');
            $table->integer('term_id')->nullable($value = true);
            $table->longText('note')->nullable($value = true);
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
        Schema::dropIfExists('purchase_orders');
    }
}
