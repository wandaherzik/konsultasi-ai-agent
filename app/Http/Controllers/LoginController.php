<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Contracts\AuthServiceInterface;

class LoginController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function index()
    {
        return view('auth.login');
    }

public function authenticate(LoginRequest $request)
{
    $user = $this->authService->login(
        $request->validated()
    );

    if (! $user) {
        return back()
            ->withInput()
            ->withErrors([
                'username' => 'Username atau password salah.'
            ]);
    }

    return match ($user->role) {

        'admin' => redirect()->route('admin.dashboard'),

        'dokter' => redirect()->route('dokter.dashboard'),

        'pasien' => redirect()->route('pasien.pasien.dashboard'),

        'kapus' => redirect()->route('kapus.dashboard'),

        default => redirect('/')
    };
}
}