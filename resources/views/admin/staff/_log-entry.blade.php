<article class="relative pl-8 pb-8 border-l-2 border-emerald-200 last:pb-0">
    <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-emerald-600 ring-4 ring-emerald-50"></span>
    <div class="flex flex-wrap items-center gap-2 mb-2">
        <time class="text-xs font-semibold text-slate-500">{{ $log->created_at->format('M j, Y g:i A') }}</time>
        <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $log->action_badge_class }}">{{ $log->action_label }}</span>
    </div>
    @if($log->modifier)
        <p class="text-xs text-slate-500 mb-2">{{ __('messages.staff.by') }} {{ $log->modifier->name }}</p>
    @endif
    @if(count($log->formatted_changes) > 0)
        <div class="overflow-x-auto rounded-xl border border-emerald-100">
            <table class="w-full text-xs">
                <thead class="bg-emerald-50">
                    <tr>
                        <th class="px-3 py-2 text-left font-bold text-emerald-900">{{ __('messages.staff.field') }}</th>
                        <th class="px-3 py-2 text-left font-bold text-emerald-900">{{ __('messages.staff.previous_col') }}</th>
                        <th class="px-3 py-2 text-left font-bold text-emerald-900">{{ __('messages.staff.new_col') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50">
                    @foreach($log->formatted_changes as $row)
                        <tr>
                            <td class="px-3 py-2 font-semibold text-slate-700">{{ $row['field'] }}</td>
                            <td class="px-3 py-2 text-slate-500">{{ $row['old'] }}</td>
                            <td class="px-3 py-2 text-slate-900">{{ $row['new'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-xs text-slate-500">{{ __('messages.staff.no_field_details') }}</p>
    @endif
</article>
