@extends('layouts.app')

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#f3faf7] flex items-center justify-center">

<div class="absolute top-6 left-6 flex items-center gap-2">
    <img src="img/logo_bg.png" class="w-8">
    <span class="font-semibold text-green-700">AppFinanceiro</span>
</div>

<div class="bg-white rounded-xl shadow-md w-[380px] p-6">
    @yield('content')
</div>

</body>
</html>
