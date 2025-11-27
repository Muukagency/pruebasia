<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use App\Services\PaymentService;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        $settings = Setting::pluck('value', 'key');

        return view('landing', [
            'services' => $services,
            'settings' => $settings,
        ]);
    }

    public function book(BookingRequest $request, PaymentService $paymentService, WhatsAppService $whatsAppService)
    {
        return DB::transaction(function () use ($request, $paymentService, $whatsAppService) {
            $client = Client::firstOrCreate(
                ['whatsapp' => $request->whatsapp],
                [
                    'full_name' => $request->full_name,
                    'email' => $request->input('email'),
                    'source' => 'web',
                    'status' => 'reservado',
                ]
            );

            $appointment = Appointment::create([
                'client_id' => $client->id,
                'service_id' => $request->service_id,
                'scheduled_date' => $request->scheduled_date,
                'scheduled_time' => $request->scheduled_time,
                'channel' => 'web',
                'status' => 'reservado',
            ]);

            $paymentLink = $paymentService->createPaymentLink($appointment);

            $whatsAppService->sendConfirmation($client, $appointment, $paymentLink);
            $whatsAppService->scheduleReminder($client, $appointment);

            return redirect()->back()->with([
                'success' => 'Reserva creada correctamente. Hemos enviado la confirmación por WhatsApp.',
                'payment_link' => $paymentLink,
            ]);
        });
    }
}
