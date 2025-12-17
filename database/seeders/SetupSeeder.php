<?php

namespace Database\Seeders;

use App\DTO\Wallet\DepositDTO;
use App\DTO\Wallet\TransferDTO;
use App\Services\User\CreateUserService;
use App\Services\Wallet\DepositService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\Wallet\TransferService;
use App\Models\User;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createUser = app(CreateUserService::class);
        $depositService = app(DepositService::class);
        $transferService = app(TransferService::class);

        $joao = $createUser->execute([
            'name'     => 'João Silva',
            'email'    => 'joao@email.com',
            'password' => '123456',
        ]);

        $maria = $createUser->execute([
            'name'     => 'Maria Souza',
            'email'    => 'maria@email.com',
            'password' => '123456',
        ]);

        $depositDTO = new DepositDTO(
            user: $joao,
            amount: 50
        );

        $transferDTO = new TransferDTO(
            from: $joao,
            to: $maria,
            amount: 20
        );

        $depositService->execute($depositDTO);
        $transferService->execute($transferDTO);
    }
}
