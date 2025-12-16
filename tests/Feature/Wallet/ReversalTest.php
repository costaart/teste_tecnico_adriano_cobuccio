<?php

use App\DTO\Wallet\DepositDTO;
use App\DTO\Wallet\ReversalDTO;
use App\Enums\TransactionStatus;
use App\Exceptions\Domain\UnauthorizedReversalException;
use App\Models\User;
use App\Services\Wallet\DepositService;
use App\Services\Wallet\ReversalService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('reverts a deposit', function () {
    $user = User::factory()->create();
    $user->wallet()->create(['balance' => 0]);

    $depositService = app(DepositService::class);
    $reversalService = app(ReversalService::class);

    $depositDTO = new DepositDTO(
        user: $user,
        amount: 100
    );

    $depositService->execute($depositDTO);

    $transaction = $user->wallet->transactions()->first();

    $reversalDTO = new ReversalDTO(
        transaction: $transaction,
        actor: $user
    );

    $reversalService->execute($reversalDTO);

    expect($user->wallet->fresh()->balance)->toBe(0);
    expect($transaction->fresh()->status)->toBe(TransactionStatus::REVERSED);
});

it('does not allow another user to revert a transaction', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();

    $owner->wallet()->create(['balance' => 100]);
    $intruder->wallet()->create(['balance' => 0]);

    $depositService  = app(DepositService::class);
    $reversalService = app(ReversalService::class);

    $depositDTO = new DepositDTO(
        user: $owner,
        amount: 100
    );

    $depositService->execute($depositDTO);

    $transaction = $owner->wallet->transactions()->first();

    $reversalDTO = new ReversalDTO(
        transaction: $transaction,
        actor: $intruder
    );

    $this->expectException(UnauthorizedReversalException::class);

    $reversalService->execute($reversalDTO);
});
