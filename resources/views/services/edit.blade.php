@extends('layouts.app')

@section('content')
<h1>Editar servicio</h1>
<form method="POST" action="{{ route('services.update', $service) }}">
    @csrf
    @method('PUT')
    <label>Nombre</label><input name="name" value="{{ $service->name }}" required>
    <label>Descripción</label><textarea name="description">{{ $service->description }}</textarea>
    <label>Duración (min)</label><input type="number" name="duration" value="{{ $service->duration }}" required>
    <label>Precio</label><input type="number" name="price" value="{{ $service->price }}" required step="0.01">
    <label>Activo</label><input type="checkbox" name="is_active" value="1" @checked($service->is_active)>
    <button type="submit">Actualizar</button>
</form>
@endsection
