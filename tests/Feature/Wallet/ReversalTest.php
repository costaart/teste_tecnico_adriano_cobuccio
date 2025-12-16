<?php

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

    $depositService->execute($user, 100);

    $transaction = $user->wallet->transactions()->first();

    $reversalService->execute($transaction);

    expect($user->wallet->fresh()->balance)->toBe(0);
    expect($transaction->fresh()->status)->toBe('reversed');
});
