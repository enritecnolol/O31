<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->date('invoice_date');
            $table->integer('user_id');
            $table->integer('supplier_id');
            $table->string('ncf');
            $table->string('type_ncf');
            $table->float('gross_amount',12,2);
            $table->float('discount_amount',12,2);
            $table->float('tax_amount',12,2);
            $table->float('total_amount',12,2);
            $table->float('invoice_balance',12,2);
            $table->boolean('invoice_status');
            $table->longText('invoice_note');
            $table->integer('invoice_term_id');
            $table->date('invoice_due');
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
        Schema::dropIfExists('expenses');
    }
}
