@extends('layouts.app')

@section('content')
<h1>Clientes</h1>
<a href="{{ route('clients.create') }}">Nuevo cliente</a>
<table>
    <thead><tr><th>Nombre</th><th>WhatsApp</th><th>Medio</th><th>Estatus</th><th></th></tr></thead>
    <tbody>
    @foreach($clients as $client)
        <tr>
            <td>{{ $client->full_name }}</td>
            <td>{{ $client->whatsapp }}</td>
            <td>{{ $client->source }}</td>
            <td>{{ $client->status }}</td>
            <td>
                <a href="{{ route('clients.edit', $client) }}">Editar</a>
                <form method="POST" action="{{ route('clients.destroy', $client) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
