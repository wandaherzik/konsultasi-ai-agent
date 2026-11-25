<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DokterDashboardController extends Controller
{
    /**
     * Dashboard dokter.
     */
    public function index(): View
    {
        $user = Auth::user();

        $dokter = $user->dokter;

        return view('dokter.dashboard', compact(
            'user',
            'dokter'
        ));
    }
}