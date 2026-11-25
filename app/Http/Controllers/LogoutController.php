<?php

namespace App\Http\Controllers;

use App\Services\Contracts\AuthServiceInterface;

class LogoutController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function __invoke()
    {
        $this->authService->logout();

        return redirect('/');
    }
}