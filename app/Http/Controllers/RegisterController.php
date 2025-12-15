<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\User\CreateUserService;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function store(RegisterRequest $request, CreateUserService $service)
    {
        $data = $request->validated();
        $user = $service->execute($data);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
