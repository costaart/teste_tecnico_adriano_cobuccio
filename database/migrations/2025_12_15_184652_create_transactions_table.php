<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'deposit',
                'transfer_in',
                'transfer_out',
                'reversal'
            ]);
            $table->decimal('amount', 15, 2);
            $table->uuid('related_transaction_id')->nullable();
            $table->foreign('related_transaction_id')->references('id')->on('transactions');
            $table->uuid('group_id')->nullable();
            $table->enum('status', [
                'posted', 
                'reversed'
            ])->default('posted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
