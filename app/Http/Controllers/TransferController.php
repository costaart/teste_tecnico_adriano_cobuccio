<?php

namespace App\Http\Controllers;

use App\DTOs\Wallet\TransferDTO;
use App\Exceptions\Domain\CannotTransferToSelfException;
use App\Exceptions\Domain\InsufficientFundsException;
use App\Exceptions\Domain\InvalidAmountException;
use App\Http\Requests\TransferRequest;
use App\Services\Wallet\TransferService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function store(TransferRequest $request, TransferService $service) {
        try {
            
            $toUser = User::where('email', $request->email)->firstOrFail();

            $dto = new TransferDTO(
                from: Auth::user(),
                to: $toUser,
                amount: $request->amount
            );

            $service->execute($dto);

            return redirect()->route('dashboard')
                ->with('success', 'Transferência realizada com sucesso!');

        } catch (InvalidAmountException | InsufficientFundsException $e) {
            return redirect()->route('transfer.show')
                ->withInput()
                ->withErrors(['amount' => $e->getMessage()]);
        } catch (CannotTransferToSelfException $e) {
            return redirect()->route('transfer.show')->with('error', $e->getMessage());
        }
    }

    public function show()
    {
        return view('wallet.transfer');
    }
}
