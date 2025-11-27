<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Services\MetaWebhookService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function meta(Request $request, MetaWebhookService $metaWebhookService)
    {
        $lead = $metaWebhookService->storeLead($request->all());
        return response()->json(['lead' => $lead]);
    }

    public function google(Request $request)
    {
        $client = Client::create([
            'full_name' => $request->input('full_name'),
            'whatsapp' => $request->input('whatsapp'),
            'email' => $request->input('email'),
            'source' => 'google_ads',
            'status' => 'reservado',
        ]);

        if ($serviceId = $request->input('service_id')) {
            Appointment::create([
                'client_id' => $client->id,
                'service_id' => $serviceId,
                'scheduled_date' => now()->toDateString(),
                'scheduled_time' => now()->toTimeString(),
                'channel' => 'google_ads',
                'status' => 'reservado',
            ]);
        }

        return response()->json(['client' => $client]);
    }
}
