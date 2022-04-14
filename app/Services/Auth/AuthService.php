<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $data): array
    {
        $attempt = Auth::attempt([
            'email'    => data_get($data, 'email'),
            'password' => data_get($data, 'password'),
        ]);

        if ($attempt) {
            return [
                'token' => Auth::user()
                    ->createToken('LaravelSanctumAuth')
                    ->plainTextToken,
            ];
        }

        abort(401, 'auth.unauthorized');
    }

    public function register(array $data): array
    {
        $user = User::create([
            'name'     => data_get($data, 'name'),
            'email'    => data_get($data, 'email'),
            'password' => bcrypt(data_get($data, 'password')),
        ]);

        return [
            'token' => $user->createToken('LaravelSanctumAuth')->plainTextToken,
        ];
    }
}