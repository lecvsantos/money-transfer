<?php

namespace App\Rules\Wallet;

use Illuminate\Support\Facades\DB;

class Extract
{
    public function execute($user_id, $only_balance = false)
    {
        try {
            $extract = DB::table(DB::raw("(
                SELECT
                    id, description, amount, type,
                    @debt_credit := type,
                    @balance := IF(@debt_credit = \"CREDIT\", @balance + amount, @balance - amount) AS balance
                FROM
                    wallets,
                    (SELECT @debt_credit := 0, @balance := 0) as vars
                WHERE
                    user_id = ?
                ORDER BY
                    id
            ) as extract
            UNION ALL
            (SELECT NULL as id, \"Saldo Final\", NULL as amount, \"BALANCE\", @balance)"))
                ->select("id", "description", "amount", "type", "balance")
                ->addBinding($user_id)
                ->get();

            if ($only_balance) {
                $extract = $extract->filter(function ($item) {
                    return $item->type == "BALANCE";
                });
                $extract = $extract->first();
            }

            return $extract;
        } catch (\Exception$e) {
            throw new \Exception($e->getMessage());
        }
    }
}
