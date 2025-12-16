<?php

use App\DTO\Wallet\DepositDTO;
use App\Models\User;
use App\Services\Wallet\DepositService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to deposit money', function () {
    $user = User::factory()->create();
    $user->wallet()->create(['balance' => 0]);

    $service = app(DepositService::class);

    $dto = new DepositDTO(
        user: $user,
        amount: 50
    );

    $service->execute($dto);

    expect($user->wallet->fresh()->balance)->toBe(50);
    expect($user->wallet->transactions)->toHaveCount(1);
});
