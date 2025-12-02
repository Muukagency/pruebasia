@extends('layouts.app')

@section('content')
<h1>Servicios</h1>
<a href="{{ route('services.create') }}">Nuevo servicio</a>
<table>
    <thead><tr><th>Nombre</th><th>Duración</th><th>Precio</th><th>Estado</th><th></th></tr></thead>
    <tbody>
    @foreach($services as $service)
        <tr>
            <td>{{ $service->name }}</td>
            <td>{{ $service->duration }} min</td>
            <td>${{ $service->price }}</td>
            <td>{{ $service->is_active ? 'Activo' : 'Inactivo' }}</td>
            <td><a href="{{ route('services.edit', $service) }}">Editar</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
