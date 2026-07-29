@extends('admin.layouts.root')

@section('title', __('Reports'))

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <h1 class="text-2xl font-black text-slate-900 mb-1">Generate Reports</h1>
            <p class="text-sm text-slate-500 mb-6">Select the topics and date range, then export as PDF or CSV.</p>

            <form method="POST" action="{{ route('admin.reports.export') }}" class="space-y-6">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="date_from" class="block text-sm font-bold text-slate-700 mb-1">Date From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ old('date_from', request('date_from', now()->startOfMonth()->format('Y-m-d'))) }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="date_to" class="block text-sm font-bold text-slate-700 mb-1">Date To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ old('date_to', request('date_to', now()->format('Y-m-d'))) }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>

                <div>
                    <p class="block text-sm font-bold text-slate-700 mb-2">Report Topics</p>
                    <div class="flex flex-wrap gap-3">
                        <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer hover:bg-slate-100 transition">
                            <input type="checkbox" name="topics[]" value="fertilizer_licenses" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" {{ in_array('fertilizer_licenses', old('topics', request('topics', []))) ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-slate-700">Fertilizer Licenses</span>
                        </label>
                        <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer hover:bg-slate-100 transition">
                            <input type="checkbox" name="topics[]" value="pesticide_shops" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" {{ in_array('pesticide_shops', old('topics', request('topics', []))) ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-slate-700">Pesticide Shop Registrations</span>
                        </label>
                        <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer hover:bg-slate-100 transition">
                            <input type="checkbox" name="topics[]" value="inspections" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" {{ in_array('inspections', old('topics', request('topics', []))) ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-slate-700">Shop Inspections</span>
                        </label>
                    </div>
                    @error('topics')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3">
                    <select name="format" class="rounded-xl border border-slate-200 px-4 py-2.5 bg-white text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="pdf">PDF</option>
                        <option value="csv">CSV</option>
                    </select>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition shadow-sm text-sm">
                        Export
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
