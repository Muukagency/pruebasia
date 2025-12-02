@extends('layouts.app')

@section('content')
<h1>Mis asignaciones</h1>
<h2>Reservas</h2>
<table>
    <thead><tr><th>Cliente</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Estatus</th></tr></thead>
    <tbody>
    @foreach($appointments as $appointment)
        <tr>
            <td>{{ $appointment->client->full_name }}</td>
            <td>{{ $appointment->service->name }}</td>
            <td>{{ $appointment->scheduled_date }}</td>
            <td>{{ $appointment->scheduled_time }}</td>
            <td>{{ $appointment->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
