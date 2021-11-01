<?php

namespace App\Rules\Validation;

class AuthValidation
{
    public static function createUserTokenValidation()
    {
        return [
            "email" => "required|email",
            "password" => "required",
        ];
    }
}
