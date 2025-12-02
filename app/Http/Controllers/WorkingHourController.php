<?php

namespace App\Http\Controllers;

use App\Models\WorkingHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkingHourController extends Controller
{
    public function index(): View
    {
        $workingHours = WorkingHour::orderBy('weekday')->get();
        return view('working-hours.index', compact('workingHours'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'weekday' => 'required|string',
            'opens_at' => 'nullable',
            'closes_at' => 'nullable',
            'is_closed' => 'boolean'
        ]);
        WorkingHour::updateOrCreate(
            ['weekday' => $data['weekday']],
            $data
        );

        return back()->with('success', 'Horario actualizado');
    }
}
