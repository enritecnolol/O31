<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->integer('client_id');
            $table->text('address')->nullable($value = true);
            $table->text('note')->nullable($value = true);
            $table->string('email');
            $table->float('subtotal',12,2);
            $table->float('total',12,2);
            $table->float('open_balance',12,2)->nullable($value = true);
            $table->string('status')->nullable($value = true);
            $table->string('paid_status')->nullable($value = true);
            $table->boolean('confirmation')->nullable($value = true);
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
        Schema::dropIfExists('invoices');
    }
}
