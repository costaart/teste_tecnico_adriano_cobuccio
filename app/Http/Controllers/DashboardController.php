<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $wallet = $user->wallet;

        $transactions = $wallet->transactions()
            ->latest()
            ->simplePaginate(4);

        return view('dashboard', [
            'user' => $user,
            'wallet' => $wallet,
            'transactions' => $transactions,
        ]);
    }
}
