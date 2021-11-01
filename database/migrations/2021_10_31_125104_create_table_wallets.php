<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWallets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable(false);
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('type', ['CREDIT', 'DEBT'])->defaultValue('CREDIT');
            $table->integer('amount')->defaultValue(0);
            $table->bigInteger('transaction_id')->unsigned()->nullable(true);
            $table->foreign('transaction_id')->references('id')->on('transactions');
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
        Schema::dropIfExists('wallets');
    }
}
