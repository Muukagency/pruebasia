<div class="space-y-3">
    <div class="flex items-center justify-between">
        <div class="text-sm font-semibold text-slate-700">Selecciona hora</div>
        <div class="text-xs text-slate-400" id="time_hint">Elige la hora perfecta</div>
    </div>
    <div id="time_slots" class="grid grid-cols-2 sm:grid-cols-3 gap-2"></div>
    <input type="hidden" name="scheduled_time" id="scheduled_time" required />
    <p id="time_empty" class="text-xs text-amber-700 hidden">No hay horarios disponibles para este día.</p>
</div>
