<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'email'    => 'O campo :attribute deve ser um e-mail válido.',
    'min' => [
        'string'  => 'O campo :attribute deve ter no mínimo :min caracteres.',
        'numeric' => 'O campo :attribute deve ser no mínimo :min.',
    ],
    'confirmed' => 'A confirmação de :attribute não confere.',
    'unique'    => 'Este :attribute já está em uso.',
    'exists' => 'Nenhum usuário foi encontrado com esse e-mail.',
    'attributes' => [
        'name'                  => 'nome',
        'email'                 => 'email',
        'password'              => 'senha',
        'password_confirmation' => 'confirmação de senha',
        'amount'                => 'valor',
    ],
];
