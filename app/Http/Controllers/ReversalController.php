<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Wallet\ReversalService;
use App\Exceptions\Domain\AlreadyReversedException;
use Illuminate\Support\Facades\Auth;

class ReversalController extends Controller
{
    public function store(Transaction $transaction, ReversalService $service)
    {
        try {
            
            if ($transaction->wallet->user_id !== Auth::id()) {
                abort(403);
            }

            $service->execute($transaction);

            return redirect()->route('dashboard')
                ->with('success', 'Operação revertida com sucesso');

        } catch (AlreadyReversedException $e) {
            return redirect()->route('dashboard')
                ->with('error', $e->getMessage());
        }
    }
}   
