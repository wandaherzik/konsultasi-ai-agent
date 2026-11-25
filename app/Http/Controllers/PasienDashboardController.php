<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PasienDashboardController extends Controller
{
    /**
     * Dashboard pasien.
     */
    public function index(): View
    {
        $user = Auth::user();

        $pasien = $user->pasien;

        return view('pasien.dashboard', compact(
            'user',
            'pasien'
        ));
    }
}