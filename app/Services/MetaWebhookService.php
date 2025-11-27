<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Log;

class MetaWebhookService
{
    public function storeLead(array $payload)
    {
        $client = Client::create([
            'full_name' => data_get($payload, 'name', 'Cliente Meta'),
            'whatsapp' => data_get($payload, 'whatsapp'),
            'email' => data_get($payload, 'email'),
            'source' => 'meta',
            'status' => 'reservado',
        ]);

        if ($serviceId = data_get($payload, 'service_id')) {
            Appointment::create([
                'client_id' => $client->id,
                'service_id' => $serviceId,
                'scheduled_date' => now()->toDateString(),
                'scheduled_time' => now()->toTimeString(),
                'channel' => 'meta',
                'status' => 'reservado',
            ]);
        }

        Log::info('Meta lead captured', ['client' => $client->id]);

        return $client;
    }
}
