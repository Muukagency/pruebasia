<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdvisorDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $clients = $user->hasRole('advisor') ? $user->clients ?? [] : collect();
        $appointments = $user->appointments()->with(['client', 'service'])->get();

        return view('advisor.dashboard', [
            'appointments' => $appointments,
            'clients' => $clients,
        ]);
    }
}
