<?php

use App\Models\User;
use App\Services\Wallet\DepositService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to deposit money', function () {
    $user = User::factory()->create();
    $user->wallet()->create(['balance' => 0]);

    $service = app(DepositService::class);

    $service->execute($user, 50);

    expect($user->wallet->fresh()->balance)->toBe(50);
    expect($user->wallet->transactions)->toHaveCount(1);
});
