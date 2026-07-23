@extends('admin.layouts.root')

@section('title', 'Fertilizer License Review')

@section('content')
    <div class="flex flex-col gap-4 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-emerald-900">Fertilizer License Review</h1>
                <p class="text-slate-600 text-sm mt-1">Confirm the application details before updating the status.</p>
            </div>
            <span class="inline-flex px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider self-start
                {{ $license->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($license->status === 'sending_to_regional_department' ? 'bg-blue-100 text-blue-800' : ($license->status === 'allowed' ? 'bg-emerald-100 text-emerald-800' : ($license->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800'))) }}">
                {{ ucfirst(str_replace('_', ' ', $license->status)) }}
            </span>
        </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.fertilizer-licenses.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50">{{ __('messages.fertilizer_license.back_to_list') }}</a>
        <span class="text-slate-300 mx-2">|</span>
        <form action="{{ route('admin.fertilizer-licenses.destroy', $license) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-xl border border-red-200 text-red-700 font-bold hover:bg-red-50" data-confirm data-confirm-message="@json(__('messages.fertilizer_license.confirm_delete'))" data-confirm-title="@json(__('messages.common.delete'))">{{ __('messages.common.delete') }}</button>
        </form>

        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 space-y-5">
                <div class="flex items-center justify-between gap-3 border-b border-emerald-50 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">{{ __('messages.fertilizer_license.applicant_details') }}</h2>
                        <p class="text-sm text-slate-500">{{ __('messages.fertilizer_license.submitted_by', ['name' => $license->user?->name ?? 'Guest applicant']) }}</p>
                    </div>
                    <span class="text-xs text-slate-500">{{ __('messages.fertilizer_license.application_id', ['id' => $license->id]) }}</span>
                    <a href="{{ route('admin.fertilizer-licenses.generate', $license) }}" title="Download Document">
                        <i data-lucide="file-text" class="text-blue-400 hover:text-blue-700 transition"></i>
                    </a>
                </div>

                <div class="grid sm:grid-cols-2 gap-5 text-sm">
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Applicant Name</span>
                        <span class="mt-1 block font-semibold text-slate-900">{{ $license->applicant_name }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Shop Name</span>
                        <span class="mt-1 block font-semibold text-slate-900">{{ $license->shop_name ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">NRC Number</span>
                        <span class="mt-1 block font-semibold text-slate-900">{{ $license->nrc_number }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Application Date</span>
                        <span class="mt-1 block font-semibold text-slate-900">{{ $license->application_date?->format('M j, Y') ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Education Level</span>
                        <span class="mt-1 block font-semibold text-slate-900">{{ $license->education_level ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Work Experience</span>
                        <span class="mt-1 block font-semibold text-slate-900">{{ $license->work_experience ? 'Yes' : 'No' }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Permanent Address</span>
                        <span class="mt-1 block font-semibold text-slate-900 whitespace-pre-line">{{ $license->permanent_address ?? '—' }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Distribution Location Address</span>
                        <span class="mt-1 block font-semibold text-slate-900 whitespace-pre-line">{{ $license->distribution_location_address ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Building Type</span>
                        <span class="mt-1 block font-semibold text-slate-900">{{ $license->building_type ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Building Dimensions</span>
                        <span class="mt-1 block font-semibold text-slate-900">{{ $license->building_dimensions ?? '—' }}</span>
                    </div>
                    @if($license->isCancelled() && $license->cancelled_reason)
                        <div class="sm:col-span-2">
                            <span class="block text-xs font-bold uppercase tracking-wide text-slate-400">{{ __('messages.fertilizer_license.cancelled_reason') }}</span>
                            <span class="mt-1 block font-semibold text-slate-900 whitespace-pre-line">{{ $license->cancelled_reason }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 space-y-5">
                <div class="border-b border-emerald-50 pb-4">
                    <h2 class="text-xl font-black text-slate-900">{{ __('messages.fertilizer_license.fertilizer_items') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('messages.fertilizer_license.items_description') }}</p>
                </div>

                <div class="space-y-4">
                    @foreach($license->items as $item)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 pb-3 mb-3">
                                <h3 class="font-black text-slate-900">{{ $item->fertilizer_name }}</h3>
                                <span class="text-xs font-bold text-slate-500">Item #{{ $item->id }}</span>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                                <div><span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Chemical Formula</span><span class="mt-1 block font-semibold text-slate-900">{{ $item->chemical_formula ?? '—' }}</span></div>
                                <div><span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Fertilizer Type</span><span class="mt-1 block font-semibold text-slate-900">{{ $item->fertilizer_type ?? '—' }}</span></div>
                                <div><span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Packaging Size</span><span class="mt-1 block font-semibold text-slate-900">{{ $item->packaging_size ?? '—' }}</span></div>
                                <div><span class="block text-xs font-bold uppercase tracking-wide text-slate-400">Weight / Volume</span><span class="mt-1 block font-semibold text-slate-900">{{ $item->weight_volume ?? '—' }}</span></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 space-y-5">
                <div class="border-b border-emerald-50 pb-4">
                    <h2 class="text-xl font-black text-slate-900">{{ __('messages.fertilizer_license.nrc_attachments') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('messages.fertilizer_license.attachments_description') }}</p>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    @foreach(['front' => 'Front NRC', 'back' => 'Back NRC'] as $key => $label)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 space-y-3">
                            <span class="block text-sm font-bold text-slate-700">{{ $label }}</span>
                            @if(data_get($license->attachment_nrc, $key))
                                <a href="{{ asset('storage/' . data_get($license->attachment_nrc, $key)) }}" target="_blank" class="block rounded-xl overflow-hidden border border-slate-200 bg-white">
                                    <img src="{{ asset('storage/' . data_get($license->attachment_nrc, $key)) }}" alt="{{ $label }}" class="w-full max-h-72 object-contain bg-white">
                                </a>
                            @else
                                <div class="rounded-xl border border-dashed border-slate-300 bg-white text-slate-500 text-sm px-4 py-10 text-center">No attachment uploaded</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 space-y-5">
                <div class="border-b border-emerald-50 pb-4">
                    <h2 class="text-xl font-black text-slate-900">{{ __('messages.fertilizer_license.township_recommendation_letter') }}</h2>
                    {{-- <p class="text-sm text-slate-500">Front and back images uploaded by the applicant.</p> --}}
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 space-y-3">
                            {{-- <span class="block text-sm font-bold text-slate-700">Township Recommendation Letter</span> --}}
                                <a href="{{ asset('storage/' . $license->township_recommendation_letter) }}" target="_blank" class="block rounded-xl overflow-hidden border border-slate-200 bg-white">
                                    <img src="{{ asset('storage/' . $license->township_recommendation_letter) }}" alt="{{ $label }}" class="w-full max-h-72 object-contain bg-white">
                                </a>
                        </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 space-y-4 sticky top-6">
                <div class="border-b border-emerald-50 pb-4">
                    <h2 class="text-xl font-black text-slate-900">{{ __('messages.fertilizer_license.status_actions') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('messages.fertilizer_license.status_actions_subtitle') }}</p>
                </div>

                <form action="{{ route('admin.fertilizer-licenses.update_status', $license) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="allowed">
                    <button type="submit" class="w-full rounded-xl bg-emerald-700 text-white font-black px-4 py-3 hover:bg-emerald-800">{{ __('messages.fertilizer_license.mark_allowed') }}</button>
                </form>

                <form action="{{ route('admin.fertilizer-licenses.update_status', $license) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="sending_to_regional_department">
                    <button type="submit" class="w-full rounded-xl bg-blue-600 text-white font-black px-4 py-3 hover:bg-blue-700">{{ __('messages.fertilizer_license.transfer_to_regional') }}</button>
                </form>

                <form action="{{ route('admin.fertilizer-licenses.update_status', $license) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="got_response_from_regional_department">
                    <button type="submit" class="w-full rounded-xl bg-indigo-600 text-white font-black px-4 py-3 hover:bg-indigo-700">{{ __('messages.fertilizer_license.mark_regional_response') }}</button>
                </form>

                <form action="{{ route('admin.fertilizer-licenses.update_status', $license) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="w-full rounded-xl bg-slate-900 text-white font-black px-4 py-3 hover:bg-slate-800">{{ __('messages.fertilizer_license.mark_completed') }}</button>
                </form>

                <form action="{{ route('admin.fertilizer-licenses.update_status', $license) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="cancelled">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.fertilizer_license.cancelled_reason') }}</label>
                        <textarea name="cancelled_reason" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="{{ __('messages.fertilizer_license.cancelled_reason_placeholder') }}"></textarea>
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-red-600 text-white font-black px-4 py-3 hover:bg-red-700" data-confirm data-confirm-message="@json(__('messages.fertilizer_license.cancel_confirm'))" data-confirm-title="@json(__('messages.fertilizer_license.cancel_and_send_back'))">{{ __('messages.fertilizer_license.cancel_and_send_back') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection