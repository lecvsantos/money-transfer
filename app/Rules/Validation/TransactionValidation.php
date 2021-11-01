<?php

namespace App\Rules\Validation;

class TransactionValidation
{
    public static function createTransactionValidation()
    {
        return [
            "amount" => "required|integer",
            "payee_id" => "required"
        ];
    }
}
