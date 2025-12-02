<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Spa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        nav a { margin-right: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #e2e8f0; padding: 0.5rem; text-align: left; }
    </style>
</head>
<body>
<nav>
    <a href="/clients">Clientes</a>
    <a href="/services">Servicios</a>
    <a href="/appointments">Reservas</a>
    <a href="/horarios">Horarios</a>
    <a href="/advisors/dashboard">Mis asignaciones</a>
</nav>
<hr>
@yield('content')
</body>
</html>
