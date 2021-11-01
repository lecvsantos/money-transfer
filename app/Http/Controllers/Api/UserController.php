<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Users\SearchUsers;
use App\Rules\Users\StoreUser;
use App\Rules\Users\UpdateUser;;
use App\Rules\Validation\UserValidation;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, SearchUsers $searchUsers)
    {
        $payload = $this->validate($request, UserValidation::searchUsersValidation());
        return response()->json($searchUsers->execute($payload), 200);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    public function store(Request $request, StoreUser $storeUser)
    {
        $payload = $this->validate($request, UserValidation::storeUserValidation());
        return response()->json($storeUser->execute($payload));
    }

    public function update(Request $request, $id, UpdateUser $updateUser)
    {
        $payload = $this->validate($request, UserValidation::updateUserValidation());
        return response()->json($updateUser->execute($id, $payload));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ["success" => true];
    }
}
