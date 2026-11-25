<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
