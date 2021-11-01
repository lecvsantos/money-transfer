<?php

namespace App\Rules\Users;

use App\Models\User;

class SearchUsers
{
    public function execute($payload)
    {
        try {
            $user = new User;
            if (isset($payload['search'])) {
                $search = $payload['search'];
                $user = $user->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                    $query->orWhere('cpf_cnpj', 'LIKE', '%' . $search . '%');
                    $query->orWhere('email', 'LIKE', '%' . $search . '%');
                });
            }
            if (isset($payload['type'])) {
                $user = $user->where('type', $payload['type']);
            }
            return $user->paginate((isset($payload['page_size'])) ? $payload["page_size"] : 10);
        } catch (\Exception$e) {
            throw new \Exception($e->getMessage());
        }
    }
}
