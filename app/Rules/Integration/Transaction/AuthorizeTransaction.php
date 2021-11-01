<?php

namespace App\Rules\Integration\Transaction;

class AuthorizeTransaction extends Transaction
{
    public function execute($transaction)
    {
        return $this->request("GET", "v3/8fafdd68-a090-496f-8c9a-3442cf30dae6", [
            "transaction_id" => $transaction->id,
            "payer_id" => $transaction->payer_id,
            "payee_id" => $transaction->payee_id,
            "amount" => $transaction->amount
        ]);   
    }
}
