<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gracias por reservar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F7F2ED] text-slate-900 flex flex-col">
    @include('components.header', [
        'logo' => $settings['branding.logo'] ?? null,
        'spaName' => $settings['landing.title'] ?? 'Spa Boutique',
    ])

    <main class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="bg-white shadow-xl rounded-3xl border border-white/60 max-w-xl w-full p-10 text-center space-y-6">
            <div class="text-3xl font-semibold">¡Gracias!</div>
            <p class="text-slate-600 leading-relaxed">{{ $message }}</p>
            @if($payment_link)
                <a href="{{ $payment_link }}" class="inline-block w-full py-3 rounded-full text-white font-semibold" style="background: linear-gradient(120deg, {{ $settings['theme.primary'] ?? '#1A1A1A' }}, {{ $settings['theme.accent'] ?? '#C7A17A' }});">Ir al pago</a>
            @endif
            @if($client_whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $client_whatsapp) }}" target="_blank" class="inline-block w-full py-3 rounded-full border border-slate-200 text-slate-800 font-semibold">Abrir WhatsApp</a>
            @endif
            <p class="text-sm text-slate-500">Hemos confirmado tu reserva y asignado un asesor. Te esperamos.</p>
        </div>
    </main>

    @include('components.footer', [
        'phone' => $settings['contact.phone'] ?? null,
        'whatsapp' => $settings['contact.whatsapp'] ?? null,
        'address' => $settings['contact.address'] ?? null,
    ])
</body>
</html>
