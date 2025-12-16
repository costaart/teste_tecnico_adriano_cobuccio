<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TransactionType;

class Transaction extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'related_transaction_id',
        'group_id',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    protected $casts = [
        'status' => TransactionStatus::class,
        'type'   => TransactionType::class,
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function relatedTransaction()
    {
        return $this->belongsTo(Transaction::class, 'related_transaction_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type->label();
    }

    public function getTypeColorAttribute(): string
    {
        return $this->type->color();
    }

    public function canBeReverted(): bool
    {
        if ($this->status !== TransactionStatus::POSTED) {
            return false;
        }

        if ($this->type === TransactionType::DEPOSIT) {
            return true;
        }

        if ($this->type === TransactionType::TRANSFER_OUT && $this->group_id !== null) {
            return true;
        }

        return false;
    }
  
}
