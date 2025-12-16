<?php

namespace App\Http\Controllers;

use App\DTO\Wallet\DepositDTO;
use App\Http\Requests\DepositRequest;
use App\Services\Wallet\DepositService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function store(DepositRequest $request, DepositService $service) {

        $dto = new DepositDTO(
            user: Auth::user(),
            amount: $request->amount
        );

        $service->execute($dto);

        return redirect()->route('dashboard')
            ->with('success', 'Depósito realizado com sucesso!');
    }

    public function show()
    {
        return view('wallet.deposit');
    }    

}
