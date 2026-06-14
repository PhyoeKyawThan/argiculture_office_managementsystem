@extends('admin.layouts.root')

@section('title', __('messages.inspections.edit_title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.inspections.edit_title') }}</h1>
        <p class="text-slate-600 text-sm">{{ $inspection->owner_name }} · {{ $inspection->township }}</p>
    </div>
    <form method="POST" action="{{ route('admin.pesticide-shop-inspections.update', $inspection) }}" class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.pesticide-shop-inspections._form', [
            'inspection' => $inspection,
            'inspectors' => $inspectors,
            'defaultInspectorId' => $defaultInspectorId,
        ])
        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition">{{ __('messages.common.update') }}</button>
            <a href="{{ route('admin.pesticide-shop-inspections.show', $inspection) }}" class="px-5 py-2.5 text-slate-600 font-bold hover:text-slate-900">{{ __('messages.common.cancel') }}</a>
        </div>
    </form>
@endsection
