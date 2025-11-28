<footer class="w-full py-10 text-center text-sm text-slate-600 bg-white/60 backdrop-blur border-t border-slate-200 mt-16">
    <div class="space-y-1">
        @if($phone ?? false)
            <div>Teléfono: <span class="font-medium text-slate-800">{{ $phone }}</span></div>
        @endif
        @if($whatsapp ?? false)
            <div>WhatsApp: <a class="text-amber-700 hover:underline" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank">{{ $whatsapp }}</a></div>
        @endif
        @if($address ?? false)
            <div>{{ $address }}</div>
        @endif
        <div class="text-xs text-slate-400">{{ __('Política de privacidad') }}</div>
    </div>
</footer>
