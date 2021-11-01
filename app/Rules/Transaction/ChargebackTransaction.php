<?php
namespace App\Rules\Transaction;

use App\Models\Transaction;
use App\Rules\Integration\Notify\NotifyChargeback;
use App\Rules\Wallet\ChargebackWalletByTransaction;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChargebackTransaction
{
    public function execute($transaction_id, $user_id)
    {
        $transaction = Transaction::where("id", $transaction_id)->where("payee_id", $user_id)->where("status", "ACCEPTED")->first();

        if ($transaction) {
            DB::beginTransaction();
            $transaction->status = "RETURNED";
            $transaction->save();
            (new ChargebackWalletByTransaction)->execute($transaction);

            // notifica o beneficiario
            $notify = (new NotifyChargeback)->execute($transaction);
            if (isset($notify->message) && $notify->message == "Success") {
                $transaction->notify_payer = true;
            } else {
                $transaction->notify_payer = false;
            }
            DB::commit();
            return $transaction;
        } else {
            DB::rollBack();
            throw new HttpException(422, "Transaction Unavailable to Chargeback");
        }
    }
}
