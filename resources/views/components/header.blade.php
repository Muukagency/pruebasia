<header class="w-full flex flex-col items-center py-8 text-center bg-white/80 backdrop-blur">
    @if($logo ?? false)
        <img src="{{ $logo }}" alt="Logo" class="h-14 w-auto mb-2 object-contain" />
    @endif
    <div class="text-sm uppercase tracking-[0.3em] text-slate-500">{{ $spaName ?? '' }}</div>
</header>
