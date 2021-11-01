<?php
namespace App\Rules\Integration\Notify;

class NotifyChargeback extends Notify
{
    public function execute($transaction)
    {
        $amount = number_format($transaction->amount / 100, 2, ',', '.');
        return $this->request("GET", "notify", [
            "message" => "A transferência para {$transaction->payee->name} no valor de R$ {$amount} foi estornada",
            "email" => $transaction->payer->email,
        ]);   
    }
}