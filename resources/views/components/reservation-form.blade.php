<div class="space-y-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="space-y-1">
            <label class="text-xs uppercase tracking-wide text-slate-500">Nombre completo</label>
            <input type="text" name="full_name" required class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" placeholder="Tu nombre" />
        </div>
        <div class="space-y-1">
            <label class="text-xs uppercase tracking-wide text-slate-500">WhatsApp</label>
            <input type="text" name="whatsapp" required class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" placeholder="Ej. +52 55..." />
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="space-y-1">
            <label class="text-xs uppercase tracking-wide text-slate-500">Email (opcional)</label>
            <input type="email" name="email" class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" placeholder="correo@ejemplo.com" />
        </div>
        <div class="space-y-1">
            <label class="text-xs uppercase tracking-wide text-slate-500">Servicio</label>
            <select name="service_id" id="service_id" class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" required>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" data-duration="{{ $service->duration }}" data-price="{{ $service->price }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="space-y-1">
        <label class="text-xs uppercase tracking-wide text-slate-500">Notas (opcional)</label>
        <textarea name="notes" rows="3" class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" placeholder="Preferencias o solicitudes especiales"></textarea>
    </div>
    <button type="submit" class="w-full py-3 rounded-full text-sm font-semibold text-white transition transform hover:-translate-y-0.5 hover:shadow-lg" style="background: linear-gradient(120deg, {{ $primary ?? '#1A1A1A' }}, {{ $accent ?? '#C7A17A' }});">
        ✔ Reservar ahora
    </button>
    <p class="text-xs text-slate-500 text-center">Confirmación inmediata por WhatsApp y link de pago al finalizar.</p>
</div>
