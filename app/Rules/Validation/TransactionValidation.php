<?php

namespace App\Rules\Validation;

use Illuminate\Validation\Rule;

class TransactionValidation
{
    public static function createTransactionValidation()
    {
        return [
            "amount" => "required|integer",
            "payee_id" => "required",
        ];
    }

    public static function searchTransactionsValidation()
    {
        return [
            "start_date" => "required|date",
            "end_date" => "required|date",
            "status" => [
                "nullable",
                Rule::in(["PENDING", "ACCEPTED", "RETURNED"]),
            ],
            "page" => "nullable",
            "page_size" => "nullable"
        ];
    }
}
