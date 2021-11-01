<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Support\Facades\Route;

/*
Rotas sem autenticação
 */
Route::post('user/token', [AuthController::class, 'createUserToken']);

Route::group(["prefix" => "user"], function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

/*
Rotas autenticadas pelo usuario
 */
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(["prefix" => "transaction"], function () {
        Route::post('/', [TransactionController::class, 'store']);
        Route::get('/{id}', [TransactionController::class, 'show']);
        Route::get('/', [TransactionController::class, 'index']);
        Route::delete('/{id}', [TransactionController::class, 'destroy']);
    });

    Route::group(["prefix" => "wallet"], function () {
        Route::get('/', [WalletController::class, 'index']);
    });
});
