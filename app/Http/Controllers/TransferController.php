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
            $service->execute(Auth::user(),
                User::findOrFail($request->to_user_id),
                $request->amount
            );

            return back()->with('success', 'Transferência realizada com sucesso');

        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
