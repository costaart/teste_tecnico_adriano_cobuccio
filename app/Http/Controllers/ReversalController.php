<?php

namespace App\Http\Controllers;

use App\DTO\Wallet\ReversalDTO;
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

            $dto = new ReversalDTO(
                transaction: $transaction,
                actor: Auth::user(),
            );
            
            $service->execute($dto);

            return redirect()->route('dashboard')
                ->with('success', 'Operação revertida com sucesso');

        } catch (AlreadyReversedException | UnauthorizedReversalException $e) {
            return redirect()->route('dashboard')
                ->with('error', $e->getMessage());
        }
    }
}   
