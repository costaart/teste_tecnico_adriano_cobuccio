<?php

namespace App\Services\Wallet;

use App\DTO\Wallet\TransferDTO;
use App\Enums\TransactionType;
use App\Exceptions\Domain\CannotTransferToSelfException;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Serviço responsável por transferências entre usuários.
 *
 * Regras de negócio:
 * - Não permite transferência para o próprio usuário
 * - Usa lock nas duas carteiras (evita concorrencia)
 * - Cria lançamentos de débito e crédito vinculados por group_id
 * - Atualiza saldo apenas via métodos de domínio (withdraw / deposit)
*/
class TransferService
{
    /**
     * Executa uma transferência entre duas carteiras.
     *
     * @param TransferDTO $dto Dados da transferência
     *
     * @throws CannotTransferToSelfException
     * @throws InsufficientFundsException
    */
    public function execute(TransferDTO $dto): void
    {
        DB::transaction(function () use ($dto) {

            if ($dto->from->id === $dto->to->id) {
                throw new CannotTransferToSelfException();
            }

            // evita concorrencia (dnv)
            $fromWallet = $dto->from->wallet()->lockForUpdate()->firstOrFail();
            $toWallet = $dto->to->wallet()->lockForUpdate()->firstOrFail();
            $groupId = Str::uuid();

            Transaction::create([
                'wallet_id' => $fromWallet->id,
                'type'      => TransactionType::TRANSFER_OUT,
                'amount'    => -$dto->amount,
                'group_id'  => $groupId,
            ]);

            Transaction::create([
                'wallet_id' => $toWallet->id,
                'type'      => TransactionType::TRANSFER_IN,
                'amount'    => $dto->amount,
                'group_id'  => $groupId,
            ]);

            $fromWallet->withdraw($dto->amount);
            $toWallet->deposit($dto->amount);
        });
    }
}
