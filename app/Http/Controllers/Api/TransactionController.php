<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\Transaction\CreateTransaction;
use App\Rules\Transaction\ShowTransaction;
use App\Rules\Validation\TransactionValidation;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request, CreateTransaction $createTransaction)
    {
        $payload = $this->validate($request, TransactionValidation::createTransactionValidation());
        $payload["payer_id"] = $request->user()->id;
        return response()->json($createTransaction->execute($payload));
    }

    public function show(Request $request, $id, ShowTransaction $showTransaction)
    {
        return response()->json($showTransaction->execute($id, $request->user()));
    }
}
