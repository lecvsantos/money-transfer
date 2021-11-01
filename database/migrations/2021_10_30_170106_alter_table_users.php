<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("cpf_cnpj")->nullable(false)->unique()->after("email_verified_at");
            $table->enum("type", ["USER", "SHOPKEEPER"])->after("cpf_cnpj")->defaultValue('USER');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cpf_cnpj');
            $table->dropColumn('type');
            $table->dropColumn('deleted_at');
        });
    }
}
