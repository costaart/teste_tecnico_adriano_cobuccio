<?php

use App\DTO\Wallet\TransferDTO;
use App\Models\User;
use App\Services\Wallet\TransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Exceptions\Domain\InsufficientFundsException;

uses(RefreshDatabase::class);

it('transfers money between users', function () {
    $from = User::factory()->create();
    $to   = User::factory()->create();

    $from->wallet()->create(['balance' => 100]);
    $to->wallet()->create(['balance' => 0]);

    $service = app(TransferService::class);

    $dto = new TransferDTO(
        from: $from,
        to: $to,
        amount: 40
    );

    $service->execute($dto);

    expect($from->wallet->fresh()->balance)->toBe(60);
    expect($to->wallet->fresh()->balance)->toBe(40);
});


it('throws exception when balance is insufficient', function () {
    $from = User::factory()->create();
    $to   = User::factory()->create();

    $from->wallet()->create(['balance' => 10]);
    $to->wallet()->create(['balance' => 0]);

    $service = app(TransferService::class);

    $dto = new TransferDTO(
        from: $from,
        to: $to,
        amount: 50
    );

    $this->expectException(InsufficientFundsException::class);

    $service->execute($dto);
});
