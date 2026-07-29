@extends('admin.layouts.root')

@section('title', $staff->name)

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-1">{{ $staff->personal_no }}</p>
            <h1 class="text-3xl font-black text-emerald-900">{{ $staff->name }}</h1>
            <p class="text-slate-600 mt-1">{{ $staff->current_position }} · {{ $staff->current_region }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.staff.edit', $staff) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition text-sm">
                <i data-lucide="pencil" class="w-4 h-4"></i> {{ __('messages.common.edit') }}
            </a>
            @if(auth()->user()->isAdmin())
                <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 border border-red-200 text-red-700 font-bold rounded-xl hover:bg-red-50 transition text-sm" data-confirm data-confirm-message="@json(__('messages.staff.confirm_delete_staff'))" data-confirm-title="@json(__('messages.common.delete'))">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> {{ __('messages.common.delete') }}
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.staff.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-slate-600 font-bold rounded-xl hover:bg-white border border-emerald-100 transition text-sm">
                {{ __('messages.common.back_to_list') }}
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 mb-10">
        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.staff.personal_short') }}</h2>
            <dl class="grid grid-cols-2 gap-3 text-sm">
                <div><dt class="text-slate-500">{{ __('messages.staff.gender') }}</dt><dd class="font-semibold capitalize">{{ $staff->gender === 'male' ? __('messages.staff.male') : __('messages.staff.female') }}</dd></div>
                <div><dt class="text-slate-500">{{ __('messages.staff.dob') }}</dt><dd class="font-semibold">{{ $staff->date_of_birth->format('M j, Y') }}</dd></div>
                <div class="col-span-2"><dt class="text-slate-500">{{ __('messages.staff.education') }}</dt><dd class="font-semibold">{{ $staff->education_level }}</dd></div>
                <div><dt class="text-slate-500">{{ __('messages.staff.married') }}</dt><dd class="font-semibold">{{ $staff->is_married ? __('messages.common.yes') : __('messages.common.no') }}</dd></div>
            </dl>
        </section>
        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.staff.current_assignment') }}</h2>
            <dl class="grid gap-3 text-sm">
                <div><dt class="text-slate-500">{{ __('messages.staff.position') }}</dt><dd class="font-semibold">{{ $staff->current_position }}</dd></div>
                <div><dt class="text-slate-500">{{ __('messages.staff.current_salary') }}</dt><dd class="font-semibold">{{ $staff->salary }}</dd></div>
                <div><dt class="text-slate-500">{{ __('messages.staff.since') }}</dt><dd class="font-semibold">{{ $staff->current_position_joining_date->format('M j, Y') }}</dd></div>
                <div><dt class="text-slate-500">{{ __('messages.staff.region') }}</dt><dd class="font-semibold">{{ $staff->current_region }}</dd></div>
                <div><dt class="text-slate-500">{{ __('messages.staff.office') }}</dt><dd class="font-semibold">{{ $staff->current_office }}</dd></div>
                <div><dt class="text-slate-500">{{ __('messages.staff.branch') }}</dt><dd class="font-semibold">{{ $staff->current_branch }}</dd></div>
            </dl>
        </section>
        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm lg:col-span-2">
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.staff.career') }}</h2>
            <dl class="grid sm:grid-cols-2 gap-3 text-sm">
                <div><dt class="text-slate-500">{{ __('messages.staff.first_joining') }}</dt><dd class="font-semibold">{{ $staff->first_joining_date->format('M j, Y') }}</dd></div>
                <div><dt class="text-slate-500">{{ __('messages.staff.assigned_position') }}</dt><dd class="font-semibold">{{ $staff->assigned_position }}</dd></div>
            </dl>
        </section>
    </div>

    <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-black text-emerald-900">{{ __('messages.staff.audit_history') }}</h2>
                <p class="text-sm text-slate-500 mt-0.5">
                    {{ trans_choice('messages.common.entry', $staff->logs->count()) }}
                    @if($logFrom || $logTo)
                        · {{ __('messages.common.matching_filters') }}
                    @endif
                </p>
            </div>
            <form method="GET" action="{{ route('admin.staff.show', $staff) }}" class="flex flex-wrap items-end gap-3">
                <div>
                    <label for="log_from" class="block text-xs font-bold text-slate-600 mb-1">{{ __('messages.common.from') }}</label>
                    <input type="date" name="log_from" id="log_from" value="{{ $logFrom }}"
                        class="rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label for="log_to" class="block text-xs font-bold text-slate-600 mb-1">{{ __('messages.common.to') }}</label>
                    <input type="date" name="log_to" id="log_to" value="{{ $logTo }}"
                        class="rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm hover:bg-emerald-200 transition">
                    {{ __('messages.common.filter') }}
                </button>
                @if($logFrom || $logTo)
                    <a href="{{ route('admin.staff.show', $staff) }}"
                        class="px-4 py-2 text-slate-600 font-bold rounded-xl text-sm hover:text-slate-900">
                        {{ __('messages.common.clear') }}
                    </a>
                @endif
            </form>
        </div>

        @forelse($staff->logs as $log)
            @include('admin.staff._log-entry', ['log' => $log])
        @empty
            <p class="text-slate-500 text-sm">
                @if($logFrom || $logTo)
                    {{ __('messages.staff.no_audit_range') }}
                @else
                    {{ __('messages.staff.no_audit') }}
                @endif
            </p>
        @endforelse
    </section>
@endsection
