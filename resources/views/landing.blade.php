<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $settings['landing.title'] ?? 'Spa Boutique' }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; color: #0f172a; margin: 0; }
        header { background: {{ $settings['theme.primary'] ?? '#0e7490' }}; color: white; padding: 2rem; text-align: center; }
        .container { max-width: 960px; margin: 2rem auto; padding: 1rem; }
        form { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        label { display: block; margin-top: 0.5rem; font-weight: bold; }
        input, select { width: 100%; padding: 0.75rem; margin-top: 0.25rem; border-radius: 8px; border: 1px solid #cbd5e1; }
        button { margin-top: 1rem; background: {{ $settings['theme.secondary'] ?? '#134e4a' }}; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; }
        .alert { background: #ecfeff; border: 1px solid #22d3ee; padding: 1rem; border-radius: 8px; }
    </style>
</head>
<body>
<header>
    <h1>{{ $settings['landing.title'] ?? 'Spa Boutique' }}</h1>
    <p>{{ $settings['landing.subtitle'] ?? 'Bienestar y relajación' }}</p>
</header>
<div class="container">
    <p>{{ $settings['landing.description'] ?? 'Agenda tu cita en segundos.' }}</p>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
            @if(session('payment_link'))
                <div><a href="{{ session('payment_link') }}">Pagar en línea</a></div>
            @endif
        </div>
    @endif

    <form method="POST" action="{{ route('landing.book') }}">
        @csrf
        <label>Nombre completo</label>
        <input name="full_name" required />

        <label>Servicio</label>
        <select name="service_id" required>
            @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->duration }} min)</option>
            @endforeach
        </select>

        <label>Fecha</label>
        <input type="date" name="scheduled_date" required />

        <label>Hora</label>
        <input type="time" name="scheduled_time" required />

        <label>WhatsApp</label>
        <input name="whatsapp" required />

        <button type="submit">Reservar</button>
    </form>
</div>
</body>
</html>
