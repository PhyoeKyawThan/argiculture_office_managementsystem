@extends('admin.layouts.root')

@section('title', __('messages.dashboard.title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.dashboard.title') }}</h1>
        <p class="text-slate-600 mt-1">{{ __('messages.dashboard.welcome', ['name' => auth()->user()->name]) }}</p>
    </div>

    @if(! empty($stats))
        <section class="mb-10">
            <h2 class="text-lg font-bold text-emerald-900 mb-4">{{ __('messages.dashboard.charts_heading') }}</h2>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('messages.dashboard.stat_farmers') }}</p>
                    <p class="text-2xl font-black text-emerald-800 mt-1">{{ number_format($stats['totals']['farmers']) }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('messages.dashboard.stat_total_inquiries') }}</p>
                    <p class="text-2xl font-black text-emerald-800 mt-1">{{ number_format($stats['totals']['inquiries']) }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('messages.dashboard.stat_total_announcements') }}</p>
                    <p class="text-2xl font-black text-emerald-800 mt-1">{{ number_format($stats['totals']['announcements']) }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('messages.dashboard.stat_total_inspections') }}</p>
                    <p class="text-2xl font-black text-emerald-800 mt-1">{{ number_format($stats['totals']['inspections']) }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-100 p-4 col-span-2 lg:col-span-1">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('messages.dashboard.stat_total_shops') }}</p>
                    <p class="text-2xl font-black text-emerald-800 mt-1">{{ number_format($stats['totals']['shops']) }}</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
                    <h3 class="font-bold text-emerald-900 mb-4">{{ __('messages.dashboard.chart_monthly_activity') }}</h3>
                    <div class="h-72">
                        <canvas id="monthlyActivityChart" aria-label="{{ __('messages.dashboard.chart_monthly_activity') }}"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
                    <h3 class="font-bold text-emerald-900 mb-4">{{ __('messages.dashboard.chart_inquiry_status') }}</h3>
                    <div class="h-72">
                        <canvas id="inquiryStatusChart" aria-label="{{ __('messages.dashboard.chart_inquiry_status') }}"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
                    <h3 class="font-bold text-emerald-900 mb-4">{{ __('messages.dashboard.chart_content_modules') }}</h3>
                    <div class="h-80">
                        <canvas id="contentModulesChart" aria-label="{{ __('messages.dashboard.chart_content_modules') }}"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
                    <h3 class="font-bold text-emerald-900 mb-4">{{ __('messages.dashboard.chart_shop_registrations') }}</h3>
                    <div class="h-80">
                        <canvas id="shopRegistrationsChart" aria-label="{{ __('messages.dashboard.chart_shop_registrations') }}"></canvas>
                    </div>
                </div>
            </div>
        </section>
    @endif

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
            <a href="{{ route('admin.inquiries.index') }}"
                class="block bg-white rounded-2xl border border-emerald-100 p-6 hover:shadow-md transition group">
                <div class="flex items-center gap-3 mb-3">
                    <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 group-hover:bg-emerald-200 transition">
                        <i data-lucide="message-circle-question" class="w-6 h-6"></i>
                    </span>
                    <h2 class="font-bold text-lg">{{ __('messages.dashboard.inquiries_title') }}</h2>
                </div>
                <p class="text-sm text-slate-600">{{ __('messages.dashboard.inquiries_desc') }}</p>
            </a>
            <a href="{{ route('admin.announcements.index') }}"
                class="block bg-white rounded-2xl border border-emerald-100 p-6 hover:shadow-md transition group">
                <div class="flex items-center gap-3 mb-3">
                    <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 group-hover:bg-emerald-200 transition">
                        <i data-lucide="newspaper" class="w-6 h-6"></i>
                    </span>
                    <h2 class="font-bold text-lg">{{ __('messages.dashboard.announcements_title') }}</h2>
                </div>
                <p class="text-sm text-slate-600">{{ __('messages.dashboard.announcements_desc') }}</p>
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

@if(! empty($stats))
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const stats = @json($stats);

                Chart.defaults.font.family = "'Instrument Sans', ui-sans-serif, system-ui, sans-serif";
                Chart.defaults.color = '#64748b';

                const gridColor = 'rgba(16, 185, 129, 0.12)';
                const emerald = '#059669';
                const emeraldLight = '#34d399';
                const teal = '#0d9488';
                const amber = '#d97706';
                const red = '#ef4444';

                const baseOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { boxWidth: 12, padding: 16, font: { weight: '600' } },
                        },
                    },
                };
                new Chart(document.getElementById('monthlyActivityChart'), {
                    type: 'pie',
                    data: {
                        labels: ['{{ __('messages.dashboard.stat_total_inquiries') }}', '{{ __('messages.dashboard.stat_total_announcements') }}', '{{ __('messages.dashboard.stat_total_inspections') }}'],
                        datasets: [{
                            data: [
                                stats.monthlyInquiries.reduce((a, b) => a + b, 0),
                                stats.monthlyAnnouncements.reduce((a, b) => a + b, 0),
                                stats.monthlyInspections.reduce((a, b) => a + b, 0)
                            ],
                            backgroundColor: ["#05f525", emeraldLight, teal],
                            borderColor: ['#ffffff', '#ffffff', '#ffffff'],
                            borderWidth: 2,
                        }],
                    },
                    options: {
                        ...baseOptions,
                        plugins: {
                            ...baseOptions.plugins,
                            legend: { 
                                position: 'bottom',
                                labels: {
                                    padding: 16,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                }
                            },
                        },
                    },
                });

                new Chart(document.getElementById('inquiryStatusChart'), {
                    type: 'pie',
                    data: {
                        labels: stats.inquiryStatus.labels,
                        datasets: [{
                            data: stats.inquiryStatus.values,
                            backgroundColor: [amber, emerald, '#f59e0b', '#10b981', '#6b7280'],
                            borderColor: ['#ffffff', '#ffffff', '#ffffff', '#ffffff', '#ffffff'],
                            borderWidth: 2,
                        }],
                    },
                    options: {
                        ...baseOptions,
                        plugins: {
                            ...baseOptions.plugins,
                            legend: { 
                                position: 'bottom',
                                labels: {
                                    padding: 16,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                }
                            },
                        },
                    },
                });

                new Chart(document.getElementById('contentModulesChart'), {
                    type: 'bar',
                    data: {
                        labels: stats.announcementsByModule.labels,
                        datasets: [{
                            label: @json(__('messages.dashboard.stat_total_announcements')),
                            data: stats.announcementsByModule.values,
                            backgroundColor: emerald,
                            borderRadius: 6,
                        }],
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: { precision: 0 },
                            },
                            y: {
                                grid: { display: false },
                            },
                        },
                    },
                });

                new Chart(document.getElementById('shopRegistrationsChart'), {
                    type: 'bar',
                    data: {
                        labels: stats.shopsByStatus.labels,
                        datasets: [{
                            label: @json(__('messages.dashboard.stat_total_shops')),
                            data: stats.shopsByStatus.values,
                            backgroundColor: [amber, emerald, red],
                            borderRadius: 8,
                            barThickness: 40,
                        }],
                    },
                    options: {
                        ...baseOptions,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { maxRotation: 45, minRotation: 0 },
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: { precision: 0 },
                            },
                        },
                    },
                });
            });
        </script>
    @endpush
@endif