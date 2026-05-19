@extends('admin.layouts.root')

@section('title', __('messages.dashboard.title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.dashboard.title') }}</h1>
        <p class="text-slate-600 mt-1">{{ __('messages.dashboard.welcome', ['name' => auth()->user()->name]) }}</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.index') }}"
                class="block bg-white rounded-2xl border border-emerald-100 p-6 hover:shadow-md transition group">
                <div class="flex items-center gap-3 mb-3">
                    <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 group-hover:bg-emerald-200 transition">
                        <i data-lucide="shield" class="w-6 h-6"></i>
                    </span>
                    <h2 class="font-bold text-lg">{{ __('messages.dashboard.users_title') }}</h2>
                </div>
                <p class="text-sm text-slate-600">{{ __('messages.dashboard.users_desc') }}</p>
            </a>
            <a href="{{ route('admin.landing-sections.index') }}"
                class="block bg-white rounded-2xl border border-emerald-100 p-6 hover:shadow-md transition group">
                <div class="flex items-center gap-3 mb-3">
                    <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 group-hover:bg-emerald-200 transition">
                        <i data-lucide="layout-template" class="w-6 h-6"></i>
                    </span>
                    <h2 class="font-bold text-lg">{{ __('messages.dashboard.landing_title') }}</h2>
                </div>
                <p class="text-sm text-slate-600">{{ __('messages.dashboard.landing_desc') }}</p>
            </a>
        @endif
        @if(auth()->user()->isBackOffice())
            <a href="{{ route('admin.staff.index') }}"
                class="block bg-white rounded-2xl border border-emerald-100 p-6 hover:shadow-md transition group">
                <div class="flex items-center gap-3 mb-3">
                    <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 group-hover:bg-emerald-200 transition">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </span>
                    <h2 class="font-bold text-lg">{{ __('messages.dashboard.staff_title') }}</h2>
                </div>
                <p class="text-sm text-slate-600">{{ __('messages.dashboard.staff_desc') }}</p>
            </a>
            <a href="{{ route('admin.pesticide-shop-inspections.index') }}"
                class="block bg-white rounded-2xl border border-emerald-100 p-6 hover:shadow-md transition group">
                <div class="flex items-center gap-3 mb-3">
                    <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 group-hover:bg-emerald-200 transition">
                        <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                    </span>
                    <h2 class="font-bold text-lg">{{ __('messages.dashboard.inspections_title') }}</h2>
                </div>
                <p class="text-sm text-slate-600">{{ __('messages.dashboard.inspections_desc') }}</p>
            </a>
        @endif
        <a href="{{ route('landing.home') }}" target="_blank"
            class="block bg-white rounded-2xl border border-emerald-100 p-6 hover:shadow-md transition group">
            <div class="flex items-center gap-3 mb-3">
                <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 group-hover:bg-emerald-200 transition">
                    <i data-lucide="external-link" class="w-6 h-6"></i>
                </span>
                <h2 class="font-bold text-lg">{{ __('messages.dashboard.public_site_title') }}</h2>
            </div>
            <p class="text-sm text-slate-600">{{ __('messages.dashboard.public_site_desc') }}</p>
        </a>
    </div>
@endsection
