<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    public function createPaymentLink(Appointment $appointment): string
    {
        $provider = config('services.payments.provider', 'conekta');
        $token = Str::uuid();

        Payment::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'provider' => $provider,
                'amount' => optional($appointment->service)->price ?? 0,
                'transaction_id' => $token,
                'status' => 'pendiente',
            ]
        );

        return url("/pagos/checkout/{$token}");
    }

    public function handleWebhook(array $payload): ?Payment
    {
        $transactionId = $payload['transaction_id'] ?? null;
        if (! $transactionId) {
            return null;
        }

        $statusMap = [
            'paid' => 'pagado',
            'paid_out' => 'pagado',
            'failed' => 'fallido',
            'expired' => 'expirado',
        ];
        $status = $statusMap[$payload['status'] ?? ''] ?? 'pendiente';

        $payment = Payment::where('transaction_id', $transactionId)->first();
        if ($payment) {
            $payment->update([
                'status' => $status,
                'metadata' => $payload,
            ]);
        }

        return $payment;
    }
}
