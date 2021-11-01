<?php

namespace App\Rules\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateUserToken
{
    public function execute($payload)
    {
        $user = User::where('email', $payload["email"])->first();

        if (!$user || !Hash::check($payload["password"], $user["password"])) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return ["access_token" => $user->createToken("user-token")->plainTextToken];
    }
}
