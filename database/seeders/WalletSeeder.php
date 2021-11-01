<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->insert([
            'description' => "Depósito por Boleto",
            'user_id' => 1,
            'type' => "CREDIT",
            'amount' => 50000,
            'transaction_id' => null,
            'created_at' => now(),
        ]);
    }
}
