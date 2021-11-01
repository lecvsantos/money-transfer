<?php

namespace App\Rules\Wallet;

use App\Models\Wallet;

class CreateWalletByTransaction
{
    public function execute($transaction)
    {
        // registra a saída na carteira do pagador
        Wallet::create([
            "description" => "Transferencia realizada para {$transaction->payee->name}",
            "user_id" => $transaction->payer_id,
            "type" => "DEBT",
            "amount" => $transaction->amount,
            "transaction_id" => $transaction->id,
        ]);

        // registra a entrada na carteira do beneficiario
        Wallet::create([
            "description" => "Transferencia recebida de {$transaction->payer->name}",
            "user_id" => $transaction->payee_id,
            "type" => "CREDIT",
            "amount" => $transaction->amount,
            "transaction_id" => $transaction->id,
        ]);
    }
}
