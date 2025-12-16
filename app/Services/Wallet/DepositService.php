<?php

namespace App\Services\Wallet;

use App\DTO\Wallet\DepositDTO;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

/**
 * Serviço responsável por processar depósitos em carteiras.
 *
 * Regras de negócio:
 * - A operação é executada dentro de uma transação 
 * - A carteira é bloqueada com lock para evitar concorrência
 * - Um lançamento financeiro é criado com status POSTED
 * - O saldo da carteira é atualizado através do método deposit()
*/
class DepositService
{
    /**
     * Executa um depósito financeiro.
     *
     * @param DepositDTO $dto Dados da operação de depósito
     * @return Transaction Lançamento financeiro criado
     *
     * @throws \DomainException Caso o valor seja inválido
    */
    public function execute(DepositDTO $dto): Transaction
    {
        return DB::transaction(function () use ($dto) {

            // concorrencia
            $wallet = $dto->user->wallet()->lockForUpdate()->first();

            $transaction = Transaction::create([
                'wallet_id' => $wallet->id,
                'type'      => TransactionType::DEPOSIT,
                'amount'    => $dto->amount,
                'status'    => TransactionStatus::POSTED,
            ]);

            $wallet->deposit($dto->amount);

            return $transaction;
        });
    }
}
