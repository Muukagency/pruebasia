@extends('layouts.app')

@section('content')
<h1>Crear reserva</h1>
<form method="POST" action="{{ route('appointments.store') }}">
    @csrf
    <label>Cliente</label>
    <select name="whatsapp">
        @foreach($clients as $client)
            <option value="{{ $client->whatsapp }}">{{ $client->full_name }} ({{ $client->whatsapp }})</option>
        @endforeach
    </select>
    <label>Nombre completo (si es nuevo)</label><input name="full_name">
    <label>Servicio</label>
    <select name="service_id" required>
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->name }}</option>
        @endforeach
    </select>
    <label>Fecha</label><input type="date" name="scheduled_date" required>
    <label>Hora</label><input type="time" name="scheduled_time" required>
    <button type="submit">Reservar</button>
</form>
@endsection
