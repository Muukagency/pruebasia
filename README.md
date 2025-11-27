# Sistema de Reservas para Spa (Laravel 11)

Este repositorio contiene la estructura inicial de un sistema de reservas para spa con landing pública, panel administrativo, automatización de leads y pagos en línea. Incluye modelos, migraciones, controladores, vistas y servicios para WhatsApp, pagos y webhooks de Meta/Google Ads.

> Nota: El entorno de ejemplo no pudo descargar dependencias externas. Una vez con acceso a internet ejecuta `composer install` y `php artisan key:generate` para completar la instalación de Laravel.

## Funcionalidades incluidas
- **Landing page** con formulario de reservas, generación de link de pago y disparo de confirmación/recordatorio por WhatsApp.
- **Módulo de clientes** con CRUD, campos de medio/estatus y soft deletes.
- **Servicios y horarios** administrables para controlar disponibilidad.
- **Reservas manuales** desde panel y asignación de asesores.
- **Pagos** con generación de link y webhook para actualizar estatus a pagado.
- **Integraciones**: webhooks para Meta Lead Ads, Google Ads y gestión de mensajes vía servicio de WhatsApp.
- **Roles** sugeridos con Spatie Permissions (admin/advisor) y panel para asesores.

## Configuración rápida
1. Copia `.env.example` a `.env` y ajusta credenciales de base de datos, WhatsApp y pagos.
2. Instala dependencias cuando tengas acceso a internet:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate --seed
   ```
3. Levanta el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

## Estructura destacada
- `app/Models`: Client, Appointment, Service, WorkingHour, Payment, Setting y Message.
- `app/Services`: manejo de WhatsApp, pagos y leads de Meta.
- `routes/web.php`: rutas públicas, panel y webhooks.
- `database/migrations`: tablas esenciales para reservas, pagos y CMS.
- `resources/views`: landing y pantallas básicas del panel administrativo.

## Próximos pasos sugeridos
- Conectar el servicio de WhatsApp a la API oficial de Meta y programar jobs de recordatorio.
- Completar autenticación (Laravel Breeze/Jetstream) y proteger las rutas del panel.
- Añadir validaciones de disponibilidad basadas en `working_hours` y evitar dobles reservas.
- Conectar con Conekta o Mercado Pago usando los tokens del `.env` y actualizar `PaymentService`.
- Implementar un bot básico en `WebhookController` para responder disponibilidad y enviar links.
