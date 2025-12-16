<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Wallet\ReversalService;
use App\Exceptions\Domain\AlreadyReversedException;
use App\Exceptions\Domain\UnauthorizedReversalException;
use Illuminate\Support\Facades\Auth;

class ReversalController extends Controller
{
    public function store(Transaction $transaction, ReversalService $service)
    {
        try {
            
            $service->execute($transaction, Auth::user());

            return redirect()->route('dashboard')
                ->with('success', 'Operação revertida com sucesso');

        } catch (AlreadyReversedException | UnauthorizedReversalException $e) {
            return redirect()->route('dashboard')
                ->with('error', $e->getMessage());
        }
    }
}   
