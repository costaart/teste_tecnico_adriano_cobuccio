<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Services\Wallet\TransferService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function store(TransferRequest $request, TransferService $service) {
        try {
            
            $toUser = User::where('email', $request->email)->firstOrFail();

            $service->execute(Auth::user(), $toUser, $request->amount);

            return redirect()->route('dashboard')
                ->with('success', 'Transferência realizada com sucesso!');

        } catch (\DomainException $e) {
            return redirect()->route('transfer.show')
            ->with('error', $e->getMessage());
        }
    }

    public function show()
    {
        return view('wallet.transfer');
    }
}
