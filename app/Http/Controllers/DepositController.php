<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Services\Wallet\DepositService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function store(DepositRequest $request, DepositService $service) {
        $service->execute(Auth::user(), $request->amount);

        return back()->with('success', 'Depósito realizado com sucesso!');
        
    }
}
