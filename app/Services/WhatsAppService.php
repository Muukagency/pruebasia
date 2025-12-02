<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsAppService
{
    public function sendConfirmation(Client $client, Appointment $appointment, ?string $paymentLink = null): void
    {
        $message = sprintf(
            '¡Hola %s! Tu cita para %s fue reservada el %s a las %s. %s',
            $client->full_name,
            optional($appointment->service)->name,
            $appointment->scheduled_date,
            $appointment->scheduled_time,
            $paymentLink ? "Paga aquí: $paymentLink" : ''
        );

        $this->sendMessage($client->whatsapp, $message);
    }

    public function scheduleReminder(Client $client, Appointment $appointment): void
    {
        $message = sprintf(
            'Recordatorio: Tienes una cita el %s a las %s para %s.',
            $appointment->scheduled_date,
            $appointment->scheduled_time,
            optional($appointment->service)->name
        );
        $this->sendMessage($client->whatsapp, $message);
    }

    public function notifyAdvisor(Appointment $appointment): void
    {
        if (! $appointment->advisor || ! $appointment->advisor->phone) {
            return;
        }

        $message = sprintf(
            'Nueva cita asignada: %s con %s el %s %s.',
            $appointment->service->name,
            $appointment->client->full_name,
            $appointment->scheduled_date,
            $appointment->scheduled_time
        );

        $this->sendMessage($appointment->advisor->phone, $message);
    }

    private function sendMessage(string $phone, string $message): void
    {
        $mode = config('services.whatsapp.mode');

        if ($mode === 'basic') {
            Log::info('WhatsApp basic link generated', [
                'link' => 'https://wa.me/'.preg_replace('/\D+/', '', $phone).'?text='.urlencode($message),
            ]);
        } else {
            Log::info('WhatsApp advanced send', [
                'phone' => $phone,
                'message' => $message,
            ]);
        }
    }
}
