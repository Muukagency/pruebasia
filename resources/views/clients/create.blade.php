@extends('layouts.app')

@section('content')
<h1>Nuevo cliente</h1>
<form method="POST" action="{{ route('clients.store') }}">
    @csrf
    <label>Nombre</label><input name="full_name" required>
    <label>WhatsApp</label><input name="whatsapp" required>
    <label>Email</label><input name="email">
    <label>Notas</label><textarea name="notes"></textarea>
    <label>Medio de origen</label>
    <select name="source">
        <option value="web">web</option>
        <option value="meta">meta</option>
        <option value="whatsapp">whatsapp</option>
        <option value="google_ads">google_ads</option>
        <option value="manual">manual</option>
    </select>
    <label>Estatus</label>
    <select name="status">
        <option value="reservado">reservado</option>
        <option value="confirmado">confirmado</option>
        <option value="pagado">pagado</option>
        <option value="atendido">atendido</option>
        <option value="cancelado">cancelado</option>
        <option value="no_show">no_show</option>
    </select>
    <button type="submit">Guardar</button>
</form>
@endsection
