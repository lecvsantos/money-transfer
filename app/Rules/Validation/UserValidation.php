<?php
namespace App\Rules\Validation;

use Illuminate\Validation\Rule;

class UserValidation
{
    public static function storeUserValidation()
    {
        return [
            "name" => "required|max:255",
            "email" => "required|email|unique:users",
            "cpf_cnpj" => "required|cpf_ou_cnpj|numeric|unique:users",
            "password" => "required",
            "type" => [
                "required",
                Rule::in(["USER", "SHOPKEEPER"]),
            ],
        ];
    }
    
    public static function updateUserValidation()
    {
        return [
            "name" => "required|max:255",
        ];
    }
    
    public static function searchUsersValidation()
    {
        return [
            "search" => "sometimes",
            "type" => [
                "nullable",
                Rule::in(["USER", "SHOPKEEPER"]),
            ],
            "page" => "nullable",
            "page_size" => "nullable"
        ];
    }
}
