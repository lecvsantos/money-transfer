<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\Auth\CreateUserToken;
use App\Rules\Validation\AuthValidation;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function createUserToken(Request $request, CreateUserToken $createUserToken)
    {
        $payload = $this->validate($request, AuthValidation::createUserTokenValidation());
        return response()->json($createUserToken->execute($payload));
    }
}
