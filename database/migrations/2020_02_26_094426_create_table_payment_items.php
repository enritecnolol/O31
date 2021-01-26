<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePaymentItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('payment_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->nullable($value = true);
            $table->float('original_amount', 12,2);
            $table->float('open_balance', 12,2)->nullable($value = true);
            $table->float('pay', 12,2);
            $table->float('discount', 12,2)->nullable($value = true);
            $table->float('balance_before_pay', 12,2)->nullable($value = true);
            $table->integer('payment_id');
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
        Schema::dropIfExists('payment_items');
    }
}
