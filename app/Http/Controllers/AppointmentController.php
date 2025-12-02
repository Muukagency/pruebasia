<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Services\WhatsAppService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(): View
    {
        $appointments = Appointment::with(['client', 'service', 'advisor'])->latest()->paginate();
        return view('appointments.index', compact('appointments'));
    }

    public function create(): View
    {
        return view('appointments.create', [
            'clients' => Client::all(),
            'services' => Service::where('is_active', true)->get(),
        ]);
    }

    public function store(BookingRequest $request, WhatsAppService $whatsAppService): RedirectResponse
    {
        $client = Client::firstOrCreate(
            ['whatsapp' => $request->whatsapp],
            [
                'full_name' => $request->full_name,
                'email' => $request->input('email'),
                'source' => $request->input('source', 'manual'),
                'status' => 'reservado',
            ]
        );

        $appointment = Appointment::create([
            'client_id' => $client->id,
            'service_id' => $request->service_id,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'advisor_id' => $request->input('advisor_id'),
            'channel' => $request->input('channel', 'panel'),
            'status' => 'reservado',
        ]);

        $whatsAppService->sendConfirmation($client, $appointment);

        return redirect()->route('appointments.index')->with('success', 'Reserva creada.');
    }
}
