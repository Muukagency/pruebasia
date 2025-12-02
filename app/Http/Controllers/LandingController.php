<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use App\Models\WorkingHour;
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
        $workingHours = WorkingHour::all();
        $appointments = Appointment::select('scheduled_date', 'scheduled_time', 'service_id')->whereDate('scheduled_date', '>=', Carbon::today())->get();

        return view('landing', [
            'services' => $services,
            'settings' => $settings,
            'workingHours' => $workingHours,
            'appointments' => $appointments,
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
                'notes' => $request->input('notes'),
            ]);

            $paymentLink = $paymentService->createPaymentLink($appointment);

            $whatsAppService->sendConfirmation($client, $appointment, $paymentLink);
            $whatsAppService->scheduleReminder($client, $appointment);

            return redirect()->route('landing.thankyou')->with([
                'booking_status' => 'Reserva creada correctamente. Hemos enviado la confirmación por WhatsApp.',
                'payment_link' => $paymentLink,
                'client_whatsapp' => $client->whatsapp,
            ]);
        });
    }

    public function thankyou()
    {
        if (!session('booking_status')) {
            return redirect()->route('landing');
        }

        $settings = Setting::pluck('value', 'key');

        return view('thankyou', [
            'settings' => $settings,
            'payment_link' => session('payment_link'),
            'message' => session('booking_status'),
            'client_whatsapp' => session('client_whatsapp'),
        ]);
    }
}
