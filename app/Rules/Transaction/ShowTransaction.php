<?php

namespace App\Rules\Transaction;

use App\Models\Transaction;

class ShowTransaction
{
    public function execute($transaction_id, $user)
    {
        $transaction = Transaction::where("id", $transaction_id)
            ->where(function ($query) use ($user) {
                $query->where("payer_id", $user->id);
                $query->orWhere("payee_id", $user->id);
            })
            ->firstOrFail();

        if ($transaction) {
            $transaction->payer;
            $transaction->payee;
        }

        return $transaction;
    }
}
