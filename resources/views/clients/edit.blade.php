@extends('layouts.app')

@section('content')
<h1>Editar cliente</h1>
<form method="POST" action="{{ route('clients.update', $client) }}">
    @csrf
    @method('PUT')
    <label>Nombre</label><input name="full_name" value="{{ $client->full_name }}" required>
    <label>WhatsApp</label><input name="whatsapp" value="{{ $client->whatsapp }}" required>
    <label>Email</label><input name="email" value="{{ $client->email }}">
    <label>Notas</label><textarea name="notes">{{ $client->notes }}</textarea>
    <label>Medio de origen</label>
    <select name="source" value="{{ $client->source }}">
        @foreach(['web','meta','whatsapp','google_ads','manual'] as $source)
            <option value="{{ $source }}" @selected($client->source === $source)>{{ $source }}</option>
        @endforeach
    </select>
    <label>Estatus</label>
    <select name="status">
        @foreach(['reservado','confirmado','pagado','atendido','cancelado','no_show'] as $status)
            <option value="{{ $status }}" @selected($client->status === $status)> {{ $status }} </option>
        @endforeach
    </select>
    <button type="submit">Actualizar</button>
</form>
@endsection
