<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEstimates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('estimatenumber');
            $table->date('estimatedate');
            $table->date('duedate');
            $table->integer('client_id');
            $table->text('address')->nullable($value= true);
            $table->longText('note')->nullable($value= true);
            $table->string('email')->nullable($value= true);
            $table->float('subtotal', 12, 2);
            $table->float('tax', 12, 2);
            $table->float('discount', 12, 2);
            $table->float('total', 12, 2);
            $table->integer('term_id');
            $table->boolean('confirmation');
            $table->timestamp('confirmation_at')->nullable($value= true);
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
        Schema::dropIfExists('estimates');
    }
}
