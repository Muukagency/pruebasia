@extends('layouts.app')

@section('content')
<h1>Horarios de atención</h1>
<table>
    <thead><tr><th>Día</th><th>Apertura</th><th>Cierre</th><th>Cerrado</th></tr></thead>
    <tbody>
    @foreach($workingHours as $wh)
        <tr>
            <td>{{ $wh->weekday }}</td>
            <td>{{ $wh->opens_at }}</td>
            <td>{{ $wh->closes_at }}</td>
            <td>{{ $wh->is_closed ? 'Sí' : 'No' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<h2>Actualizar</h2>
<form method="POST" action="{{ route('working-hours.store') }}">
    @csrf
    <label>Día</label><input name="weekday" required>
    <label>Apertura</label><input type="time" name="opens_at">
    <label>Cierre</label><input type="time" name="closes_at">
    <label>Cerrado</label><input type="checkbox" name="is_closed" value="1">
    <button type="submit">Guardar</button>
</form>
@endsection
