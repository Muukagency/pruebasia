@extends('layouts.app')

@section('content')
<h1>Nuevo servicio</h1>
<form method="POST" action="{{ route('services.store') }}">
    @csrf
    <label>Nombre</label><input name="name" required>
    <label>Descripción</label><textarea name="description"></textarea>
    <label>Duración (min)</label><input type="number" name="duration" required>
    <label>Precio</label><input type="number" name="price" required step="0.01">
    <label>Activo</label><input type="checkbox" name="is_active" value="1" checked>
    <button type="submit">Guardar</button>
</form>
@endsection
