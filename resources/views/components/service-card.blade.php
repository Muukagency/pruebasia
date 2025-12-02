<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-white/60">
    <div class="relative h-48 w-full bg-slate-100">
        <img src="{{ $image ?? 'https://images.unsplash.com/photo-1616628182501-17863e5f2f1f?auto=format&fit=crop&w=1400&q=80' }}" alt="Servicio" class="absolute inset-0 h-full w-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-transparent"></div>
        <div class="absolute bottom-4 left-4 text-white">
            <div class="text-lg font-semibold tracking-tight" data-service-name>{{ $serviceName ?? 'Servicio destacado' }}</div>
            <div class="text-sm text-white/80">{{ $duration ?? '' }} {{ __('min') }}</div>
        </div>
    </div>
    <div class="p-6 space-y-4">
        <div class="text-2xl font-semibold text-slate-900" data-service-name>{{ $serviceName ?? 'Masaje Signature' }}</div>
        <div class="text-amber-800 font-medium text-lg">{{ $price ?? '' }}</div>
        <p class="text-slate-600 leading-relaxed">{{ $welcome ?? 'Elige tu horario ideal y disfruta una experiencia boutique diseñada para tu bienestar.' }}</p>
        @if($contact ?? false)
            <div class="text-sm text-slate-500 space-y-1">
                @if($contact['phone'] ?? false)
                    <div>Tel: {{ $contact['phone'] }}</div>
                @endif
                @if($contact['whatsapp'] ?? false)
                    <div>WhatsApp: {{ $contact['whatsapp'] }}</div>
                @endif
                @if($contact['email'] ?? false)
                    <div>Email: {{ $contact['email'] }}</div>
                @endif
            </div>
        @endif
    </div>
</div>
