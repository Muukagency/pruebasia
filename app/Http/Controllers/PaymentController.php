<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function webhook(Request $request, PaymentService $paymentService): Response
    {
        $payment = $paymentService->handleWebhook($request->all());

        if ($payment && $payment->status === 'pagado' && $payment->appointment) {
            $payment->appointment->client->update(['status' => 'pagado']);
        }

        return response()->json(['ok' => true]);
    }

    public function showLink(Appointment $appointment, PaymentService $paymentService)
    {
        $link = $paymentService->createPaymentLink($appointment);
        return response()->json(['payment_link' => $link]);
    }
}
