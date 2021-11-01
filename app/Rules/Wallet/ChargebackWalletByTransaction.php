<?php
namespace App\Rules\Wallet;

use App\Models\Wallet;

class ChargebackWalletByTransaction
{
    public function execute($transaction)
    {
        // registra a saída na carteira do beneficiário
        Wallet::create([
            "description" => "Estorno realizado para {$transaction->payer->name}",
            "user_id" => $transaction->payee_id,
            "type" => "DEBT",
            "amount" => $transaction->amount,
            "transaction_id" => $transaction->id,
        ]);

        // registra a entrada na carteira do pagador
        Wallet::create([
            "description" => "Estorno recebido de {$transaction->payee->name}",
            "user_id" => $transaction->payer_id,
            "type" => "CREDIT",
            "amount" => $transaction->amount,
            "transaction_id" => $transaction->id,
        ]);
    }
}
