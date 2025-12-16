<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\CreateUserService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, CreateUserService $service)
    {
        $user = $service->execute($request->validated());

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
