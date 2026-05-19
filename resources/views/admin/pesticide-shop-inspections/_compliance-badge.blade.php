@props(['compliant', 'label'])

<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $compliant ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}"
    title="{{ $label }}">
    @if($compliant)
        <i data-lucide="check" class="w-3 h-3"></i>
    @else
        <i data-lucide="x" class="w-3 h-3"></i>
    @endif
    <span class="sr-only">{{ $label }}:</span>
</span>
