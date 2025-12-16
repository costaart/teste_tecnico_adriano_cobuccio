<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Wallet\ReversalService;
use App\Exceptions\Domain\AlreadyReversedException;

class ReversalController extends Controller
{
    public function store(Transaction $transaction, ReversalService $service)
    {
        try {
            $service->execute($transaction);

            return back()->with('success', 'Operação revertida com sucesso');

        } catch (AlreadyReversedException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
