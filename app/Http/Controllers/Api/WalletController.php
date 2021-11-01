<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\Wallet\Extract;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request, Extract $extract)
    {
        return response()->json($extract->execute($request->user()->id, false));
    }
}
