<?php

namespace App\Rules\Transaction;

use App\Models\Transaction;
use App\Models\User;
use App\Rules\Integration\Notify\NotifyPayee;
use App\Rules\Integration\Transaction\AuthorizeTransaction;
use App\Rules\Wallet\CreateWalletByTransaction;
use App\Rules\Wallet\Extract;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateTransaction
{
    public function execute($payload)
    {
        try {
            // verifica se o usuario pode realizar transferencias para outro
            if ($this->verifyPayer($payload["payer_id"])) {

                // Busca o saldo do usuario pagador
                $extract = (new Extract)->execute($payload["payer_id"], true);

                // Se tiver saldo disponivel realiza a transacao
                if (isset($extract) && $extract->balance >= $payload["amount"]) {
                    DB::beginTransaction();
                    $transaction = new Transaction;
                    $transaction->payer_id = $payload["payer_id"];
                    $transaction->payee_id = $payload["payee_id"];
                    $transaction->status = "PENDING";
                    $transaction->amount = $payload["amount"];
                    $transaction->save();

                    // servico autorizador externo
                    $authorize = (new AuthorizeTransaction)->execute($transaction);
                    // se autorizado altera o status da transacao e atualiza os valores na carteira
                    if (isset($authorize) && $authorize->message == "Autorizado") {
                        $transaction->status = "ACCEPTED";
                        $transaction->save();
                        (new CreateWalletByTransaction)->execute($transaction);

                        // notifica o beneficiario
                        $notify = (new NotifyPayee)->execute($transaction);
                        if (isset($notify->message) && $notify->message == "Success") {
                            $transaction->notify_payee = true;
                        } else {
                            $transaction->notify_payee = false;
                        }
                    }
                    DB::commit();
                    return $transaction;
                } else {
                    DB::rollBack();
                    throw new HttpException(422, "Balance Unavailable");
                }
            } else {
                throw new HttpException(422, "User type does not allow transfers");
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getCode(), $e->getMessage());
        }
    }

    private function verifyPayer($user_id)
    {
        $user = User::findOrFail($user_id);
        if ($user->type == "USER") {
            return true;
        }
        return false;
    }
}
