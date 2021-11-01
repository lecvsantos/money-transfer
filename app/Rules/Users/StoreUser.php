<?php

namespace App\Rules\Users;

use App\Models\User;

class StoreUser
{
    public function execute($payload)
    {
        try {

            $user = new User();
            $user->name = $payload["name"];
            $user->email = $payload["email"];
            $user->cpf_cnpj = $payload["cpf_cnpj"];
            $user->type = $payload["type"];
            $user->password = bcrypt($payload["password"]);
            $user->save();

            return $user;
        } catch (\Exception$e) {
            throw new \Exception($e->getMessage());
        }
    }
}
