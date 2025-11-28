<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['landing.title'] ?? 'Spa Boutique' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --bg: {{ $settings['theme.background'] ?? '#F7F2ED' }};
            --text: {{ $settings['theme.text'] ?? '#1A1A1A' }};
            --primary: {{ $settings['theme.primary'] ?? '#1A1A1A' }};
            --accent: {{ $settings['theme.accent'] ?? '#C7A17A' }};
        }
        body { font-family: 'Inter', 'DM Sans', 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[var(--bg)] text-[var(--text)]">
    @include('components.header', [
        'logo' => $settings['branding.logo'] ?? null,
        'spaName' => $settings['landing.title'] ?? 'Spa Boutique',
    ])

    <main class="max-w-6xl mx-auto px-4 pb-16">
        <section class="text-center space-y-4 py-6">
            <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight">{{ $settings['landing.title'] ?? 'Reserva tu masaje ideal' }}</h1>
            <p class="text-lg text-slate-600">{{ $settings['landing.subtitle'] ?? 'Agenda en segundos — confirmación inmediata por WhatsApp' }}</p>
            <p class="text-slate-500 leading-relaxed max-w-3xl mx-auto">{{ $settings['landing.description'] ?? 'Diseñamos experiencias boutique para tu descanso. Selecciona fecha y hora y nosotros nos encargamos del resto.' }}</p>
        </section>

        <section class="grid lg:grid-cols-[1.1fr_1.2fr] gap-8 items-start">
            @php
                $firstService = $services->first();
            @endphp
            @include('components.service-card', [
                'image' => $settings['landing.hero_image'] ?? null,
                'serviceName' => $firstService->name ?? 'Masaje Signature',
                'duration' => $firstService->duration ?? '60',
                'price' => isset($firstService) ? '$'.number_format($firstService->price, 2) : '$0.00',
                'welcome' => $settings['landing.welcome'] ?? 'Elige tu horario ideal y disfruta una experiencia boutique diseñada para tu bienestar.',
                'contact' => [
                    'phone' => $settings['contact.phone'] ?? null,
                    'whatsapp' => $settings['contact.whatsapp'] ?? null,
                    'email' => $settings['contact.email'] ?? null,
                ],
            ])

            <div class="bg-white/90 backdrop-blur shadow-2xl rounded-3xl border border-white/60 p-6 sm:p-8 space-y-6">
                <form method="POST" action="{{ route('landing.book') }}" id="booking_form" class="space-y-6">
                    @csrf
                    @include('components.calendar-selector')
                    @include('components.time-selector')
                    @include('components.reservation-form', [
                        'services' => $services,
                        'primary' => $settings['theme.primary'] ?? '#1A1A1A',
                        'accent' => $settings['theme.accent'] ?? '#C7A17A',
                    ])
                </form>
                <div class="text-xs text-slate-400 text-center">Confirmación inmediata | Link de pago (Mercado Pago / Conekta) | Mensaje automático por WhatsApp</div>
            </div>
        </section>

        @if(($settings['landing.show_reviews'] ?? false))
            <section class="mt-14 text-center">
                <h2 class="text-2xl font-semibold mb-3">Opiniones</h2>
                <p class="text-slate-500">Próximamente sección de reseñas minimalista.</p>
            </section>
        @endif
    </main>

    @include('components.footer', [
        'phone' => $settings['contact.phone'] ?? null,
        'whatsapp' => $settings['contact.whatsapp'] ?? null,
        'address' => $settings['contact.address'] ?? null,
    ])

    <script>
        const workingHours = @json($workingHours->map(function($item){
            return [
                'weekday' => strtolower($item->weekday),
                'opens_at' => $item->opens_at,
                'closes_at' => $item->closes_at,
                'is_closed' => (bool) $item->is_closed,
            ];
        }));
        const appointments = @json($appointments->map(function($item){
            return [
                'date' => $item->scheduled_date->format('Y-m-d'),
                'time' => $item->scheduled_time,
                'service_id' => $item->service_id,
            ];
        }));
        const services = @json($services->map(function($service){
            return [
                'id' => $service->id,
                'name' => $service->name,
                'duration' => $service->duration,
                'price' => $service->price,
            ];
        }));

        const weekdayMap = {
            sunday: 0,
            monday: 1,
            tuesday: 2,
            wednesday: 3,
            thursday: 4,
            friday: 5,
            saturday: 6,
        };

        const workingMap = workingHours.reduce((acc, item) => {
            acc[item.weekday] = item;
            return acc;
        }, {});

        const dateInput = document.getElementById('selected_date');
        const timeSlots = document.getElementById('time_slots');
        const timeEmpty = document.getElementById('time_empty');
        const scheduledTimeInput = document.getElementById('scheduled_time');
        const serviceSelect = document.getElementById('service_id');
        const timeHint = document.getElementById('time_hint');

        function zeroPad(num) { return num.toString().padStart(2, '0'); }

        function getServiceDuration() {
            const option = serviceSelect.selectedOptions[0];
            return option ? parseInt(option.dataset.duration, 10) || 30 : 30;
        }

        function blockedTimesFor(dateStr) {
            return appointments
                .filter(a => a.date === dateStr)
                .map(a => a.time);
        }

        function timesForDay(dateStr) {
            const dateObj = new Date(dateStr + 'T00:00:00');
            if (isNaN(dateObj)) return [];
            const weekdayName = dateObj.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
            const config = workingMap[weekdayName];
            if (!config || config.is_closed) return [];

            const interval = getServiceDuration();
            const [openHour, openMin] = config.opens_at.split(':').map(Number);
            const [closeHour, closeMin] = config.closes_at.split(':').map(Number);
            const startMinutes = openHour * 60 + openMin;
            const endMinutes = closeHour * 60 + closeMin;
            const blocked = new Set(blockedTimesFor(dateStr));
            const slots = [];

            for (let minutes = startMinutes; minutes + interval <= endMinutes; minutes += interval) {
                const hh = zeroPad(Math.floor(minutes / 60));
                const mm = zeroPad(minutes % 60);
                const candidate = `${hh}:${mm}`;
                if (!blocked.has(candidate)) {
                    slots.push(candidate);
                }
            }
            return slots;
        }

        function renderSlots(dateStr) {
            const slots = timesForDay(dateStr);
            timeSlots.innerHTML = '';
            scheduledTimeInput.value = '';
            if (!slots.length) {
                timeEmpty.classList.remove('hidden');
                return;
            }
            timeEmpty.classList.add('hidden');
            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full px-3 py-2 rounded-xl border border-slate-200 text-sm hover:border-amber-200 hover:bg-amber-50 transition';
                btn.textContent = slot;
                btn.onclick = () => {
                    scheduledTimeInput.value = slot;
                    document.querySelectorAll('#time_slots button').forEach(b => b.classList.remove('ring-2', 'ring-amber-300', 'bg-amber-50'));
                    btn.classList.add('ring-2', 'ring-amber-300', 'bg-amber-50');
                };
                timeSlots.appendChild(btn);
            });
        }

        dateInput.addEventListener('change', (e) => {
            renderSlots(e.target.value);
        });

        serviceSelect.addEventListener('change', () => {
            if (dateInput.value) {
                renderSlots(dateInput.value);
            }
            const selected = services.find(s => s.id == serviceSelect.value);
            if (selected) {
                timeHint.textContent = `${selected.duration} min · ${new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(selected.price)}`;
                const serviceNameEls = document.querySelectorAll('[data-service-name]');
                serviceNameEls.forEach(el => el.textContent = selected.name);
            }
        });

        // Prefill date with today
        const today = new Date();
        const isoToday = today.toISOString().split('T')[0];
        dateInput.value = isoToday;
        renderSlots(isoToday);
        serviceSelect.dispatchEvent(new Event('change'));
    </script>
</body>
</html>
