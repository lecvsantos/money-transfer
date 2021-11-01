<?php

namespace App\Rules\Transaction;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class SearchTransactions
{
    public function execute($payload)
    {
        try {
            $transactions = Transaction::whereBetween(DB::raw("DATE(created_at)"), [$payload["start_date"], $payload["end_date"]])
                ->where(function ($query) use ($payload) {
                    $query->where("payer_id", $payload["user_id"]);
                    $query->orWhere("payee_id", $payload["user_id"]);
                });

            if (isset($payload["status"])) {
                $transactions->where("status", $payload["status"]);
            }

            $transactions = $transactions->paginate((isset($payload["page_size"]) ? $payload["page_size"] : 10));

            if ($transactions->count() > 0) {
                $transactions = $this->getTransactionsDetails($transactions, $payload["user_id"]);
            }

            return $transactions;
        } catch (\Exception$e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function getTransactionsDetails($transactions, $user_id)
    {
        foreach ($transactions as $transaction) {
            $transaction->payer;
            $transaction->payee;
            $transaction->wallet = $transaction->wallet()->where("user_id", $user_id)->get();
        }

        return $transactions;
    }
}
