<?php

namespace App\Models;

use App\Exceptions\Domain\InsufficientFundsException;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use InvalidArgumentException;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException();
        }

        $this->increment('balance', $amount);
    }

    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException();
        }

        if ($this->balance < $amount) {
            throw new InsufficientFundsException();
        }

        $this->decrement('balance', $amount);
    }
}
