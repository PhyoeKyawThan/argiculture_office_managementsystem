@extends('admin.layouts.root')

@section('title', __('messages.inspections.new_title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.inspections.new_title') }}</h1>
        <p class="text-slate-600 text-sm mt-1">{{ __('messages.inspections.new_subtitle') }}</p>
    </div>
    <form method="POST" action="{{ route('admin.pesticide-shop-inspections.store') }}" class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm" enctype="multipart/form-data">
        @csrf
        @include('admin.pesticide-shop-inspections._form', [
            'inspectors' => $inspectors,
            'defaultInspectorId' => $defaultInspectorId,
        ])
        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition">{{ __('messages.inspections.save') }}</button>
            <a href="{{ route('admin.pesticide-shop-inspections.index') }}" class="px-5 py-2.5 text-slate-600 font-bold hover:text-slate-900">{{ __('messages.common.cancel') }}</a>
        </div>
    </form>
@endsection
