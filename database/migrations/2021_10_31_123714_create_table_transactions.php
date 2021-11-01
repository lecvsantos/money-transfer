<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payer_id')->unsigned()->nullable(false);
            $table->foreign('payer_id')->references('id')->on('users');
            $table->bigInteger('payee_id')->unsigned()->nullable(false);
            $table->foreign('payee_id')->references('id')->on('users');
            $table->enum('status', ['PENDING', 'ACCEPTED', 'RETURNED'])->defaultValue('PENDING');
            $table->integer('amount')->defaultValue(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
