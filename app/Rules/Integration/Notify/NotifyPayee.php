<?php
namespace App\Rules\Integration\Notify;

class NotifyPayee extends Notify
{
    public function execute($transaction)
    {
        $amount = number_format($transaction->amount / 100, 2, ',', '.');
        return $this->request("GET", "notify", [
            "message" => "Você recebeu uma transferência de {$transaction->payer->name} do valor de R$ {$amount}",
            "email" => $transaction->payee->email,
        ]);   
    }
}