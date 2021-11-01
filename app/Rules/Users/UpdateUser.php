<?php

namespace App\Rules\Users;

use App\Models\User;

class UpdateUser
{
    public function execute($user_id, $payload)
    {
        try {

            $user = User::findOrFail($user_id);
            $user->name = $payload["name"];
            $user->save();

            return $user;
        } catch (\Exception$e) {
            throw new \Exception($e->getMessage());
        }
    }
}
