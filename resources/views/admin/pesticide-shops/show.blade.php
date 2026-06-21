@extends('admin.layouts.root')

@section('title', $pesticideShop->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pesticide-shops.index') }}" class="text-sm font-bold text-emerald-700 flex items-center gap-1">
            &larr; {{ __('messages.common.back_to_list') }}
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-6">
                    <div>
                        <h1 class="text-2xl font-black text-slate-900">{{ $pesticideShop->name }}</h1>
                        <p class="text-slate-500 text-sm mt-1">Applicant Name: <span class="font-bold text-slate-800">{{ $pesticideShop->name }}</span></p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider
                        @if($pesticideShop->status === 'approved') bg-emerald-100 text-emerald-800
                        @elseif($pesticideShop->status === 'rejected') bg-red-100 text-red-800
                        @else bg-amber-100 text-amber-800 @endif">
                        {{ $pesticideShop->status }}
                    </span>
                </div>

                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">၁။ လျှောက်ထားသူနှင့် ဆိုင်အချက်အလက်</h3>
                <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm border-b border-slate-100 pb-6">
                    <div>
                        <dt class="font-bold text-slate-400">NRC Number</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->nrc }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Township (မြို့နယ်)</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->township }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Education / Qualifications</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->education }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Operation Business Type</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5 capitalize">{{ $pesticideShop->retail_or_wholesale }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="font-bold text-slate-400">Permanent Address (အမြဲတမ်းနေရပ်လိပ်စာ)</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->stable_address }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="font-bold text-slate-400">Shop / Storage Address (ရောင်းချမည့်နေရာလိပ်စာ)</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->requested_selling_address }}</dd>
                    </div>
                </dl>

                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mt-6 mb-3">၂။ ဆိုင်အဆောက်အအုံဖွဲ့စည်းမှု တည်ဆောက်ချက်</h3>
                <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div>
                        <dt class="font-bold text-slate-400">Building Type (အဆောက်အအုံအမျိုးအစား)</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->building_type }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Dimensions (အကျယ်အဝန်း)</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->building_area }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Distance From Restaurants/Pharmacies</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->from_restaurant_distance }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Emergency Preparedness Plan</dt>
                        <dd class="mt-1">
                            @if($pesticideShop->has_emergency_preparedness_plan)
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">ပြင်ဆင်ပြီးရှိပါသည်</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">ပြင်ဆင်ထားမှုမရှိပါ</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900">၃။ ပတ်ဝန်းကျင်သဘောတူညီချက်များ (Surrounding Agreements)</h3>
                
                @php
                    // Decode structural metadata safely if it exists inside string/json representation
                    $agreements = is_string($pesticideShop->surrounding_aggreements) 
                        ? json_decode($pesticideShop->surrounding_aggreements, true) 
                        : $pesticideShop->surrounding_aggreements;
                @endphp

                @if(!empty($agreements))
                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                        <div><span class="text-slate-400 block font-medium">Village</span><span class="font-bold text-slate-800">{{ data_get($agreements, 'location.village', '—') }}</span></div>
                        <div><span class="text-slate-400 block font-medium">Village Tract</span><span class="font-bold text-slate-800">{{ data_get($agreements, 'location.village_tract', '—') }}</span></div>
                        <div><span class="text-slate-400 block font-medium">Township</span><span class="font-bold text-slate-800">{{ data_get($agreements, 'location.township', '—') }}</span></div>
                        <div><span class="text-slate-400 block font-medium">Region/State</span><span class="font-bold text-slate-800">{{ data_get($agreements, 'location.region_state', '—') }}</span></div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">ပတ်ဝန်းကျင် နယ်နိမိတ်ဆိုင်ရာ ထောက်ခံသူများ ဇယား</p>
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-2xl overflow-hidden bg-white">
                            @foreach([
                                'store_front' => 'အရှေ့ဘက် (Store Front)',
                                'store_end' => 'အနောက်ဘက် (Store End)',
                                'store_south' => 'တောင်ဘက် (Store South)',
                                'store_north' => 'မြောက်ဘက် (Store North)'
                            ] as $dirKey => $dirLabel)
                                @php $boundary = data_get($agreements, "boundaries.{$dirKey}"); @endphp
                                <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-sm">
                                    <div class="space-y-0.5">
                                        <span class="text-xs font-black text-emerald-800 bg-emerald-50 border border-emerald-100/50 px-2 py-0.5 rounded-md">{{ $dirLabel }}</span>
                                        <div class="font-bold text-slate-800 mt-1.5">အမည် - {{ data_get($boundary, 'name', '—') }}</div>
                                        <div class="text-xs text-slate-500">မှတ်ပုံတင် - {{ data_get($boundary, 'nrc', '—') }}</div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if(data_get($boundary, 'signature'))
                                            <a href="{{ asset('storage/' . data_get($boundary, 'signature')) }}" target="_blank" class="block border border-slate-200 rounded-xl overflow-hidden p-1 bg-slate-50 hover:border-emerald-500 transition max-h-16">
                                                <img src="{{ asset('storage/' . data_get($boundary, 'signature')) }}" alt="Signature" class="h-12 w-auto object-contain">
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400 italic">No Signature File</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic">No agreements metadata provided.</p>
                @endif
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900">၄။ ပူးတွဲတင်ပြရန် စာရွက်စာတမ်းများ (Attachments)</h3>
                
                @php
                    $attachments = is_string($pesticideShop->attachments) 
                        ? json_decode($pesticideShop->attachments, true) 
                        : $pesticideShop->attachments;
                @endphp

                @if(!empty($attachments))
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach([
                            'card_front' => 'သင်တန်းဆင်းကတ်ပြား (အရှေ့)',
                            'card_back' => 'သင်တန်းဆင်းကတ်ပြား (အနောက်)',
                            'certificate' => 'သင်တန်းဆင်းလက်မှတ် (Certificate)',
                            'ward_approval' => 'ရပ်ကွက်ထောက်ခံစာ (Ward Approval)'
                        ] as $attKey => $attLabel)
                            <div class="border border-slate-100 rounded-2xl p-4 bg-slate-50/50 flex flex-col justify-between space-y-3">
                                <div>
                                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $attKey }}</span>
                                    <span class="block text-sm font-bold text-slate-800 mt-0.5">{{ $attLabel }}</span>
                                </div>
                                @if(isset($attachments[$attKey]))
                                    <div class="relative border border-slate-200 rounded-xl bg-white overflow-hidden group">
                                        <img src="{{ asset('storage/' . $attachments[$attKey]) }}" alt="{{ $attLabel }}" class="w-full h-32 object-contain p-2">
                                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                            <a href="{{ asset('storage/' . $attachments[$attKey]) }}" target="_blank" class="px-3 py-1.5 bg-white text-slate-900 font-bold text-xs rounded-xl shadow-md hover:bg-slate-100">
                                                Open Full File &nearr;
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="h-32 rounded-xl border border-dashed border-slate-200 flex items-center justify-center bg-white">
                                        <span class="text-xs text-slate-400 italic">Not Uploaded</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic">No file attachments array found.</p>
                @endif
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-black text-slate-900">၅။ လျှောက်ထားသူ၏ လက်မှတ် (Signature)</h3>
                    <p class="text-xs text-slate-400 mt-1">Submitted dynamic signature identity file parameter.</p>
                </div>
                <div>
                    @if($pesticideShop->signature)
                        <a href="{{ asset('storage/' . $pesticideShop->signature) }}" target="_blank" class="block border border-slate-200 rounded-2xl overflow-hidden bg-slate-50 p-2 hover:border-emerald-600 transition max-w-[200px]">
                            <img src="{{ asset('storage/' . $pesticideShop->signature) }}" alt="Applicant Signature" class="h-16 w-auto max-w-full object-contain mx-auto">
                        </a>
                    @else
                        <span class="text-xs text-slate-400 italic">No signature file present.</span>
                    @endif
                </div>
            </div>

            @if($pesticideShop->status !== 'pending' && $pesticideShop->reviewed_at)
                <div class="bg-slate-50 border border-slate-100 rounded-3xl p-4 text-xs text-slate-500">
                    Reviewed by <span class="font-bold text-slate-700">{{ $pesticideShop->reviewer?->name ?? 'System Administrator' }}</span> on {{ $pesticideShop->reviewed_at->format('M j, Y \a\t H:i') }}
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl border border-red-200 bg-red-50 p-6 text-sm text-red-800 shadow-sm">
                <a href="{{ route('admin.pesticide-shops.download', [$pesticideShop->id, 'format' => 'pdf']) }}" class="btn-pdf">Download PDF</a>
                <a href="{{ route('admin.pesticide-shops.download', [$pesticideShop->id, 'format' => 'docx']) }}" class="btn-word">
                    Download Word (.docx)
                </a>
                <a href="{{ route('admin.pesticide-shops.download_agreements', [$pesticideShop->id, 'format' => 'docx']) }}" class="btn-word">
                    Download Agreement Word (.docx)
                </a>
            </div>
            @if($pesticideShop->status === 'rejected' && $pesticideShop->rejection_reason)
                <div class="rounded-3xl border border-red-200 bg-red-50 p-6 text-sm text-red-800 shadow-sm">
                    <p class="font-black text-base flex items-center gap-1 mb-2">
                        <span>&otimes;</span> Application Rejected
                    </p>
                    <p class="font-bold mb-1 text-xs text-red-600 uppercase tracking-wider">Rejection Reason Specified:</p>
                    <p class="text-slate-700 leading-relaxed bg-white/60 p-3 rounded-xl border border-red-100 mt-1">{{ $pesticideShop->rejection_reason }}</p>
                </div>
            @endif

            @if($pesticideShop->status === 'pending')
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm h-fit space-y-4">
                    <h2 class="text-lg font-black text-slate-900">Application Review</h2>
                    <p class="text-xs text-slate-400">Evaluate application materials, attachments, and neighborhood validations before verifying approval status.</p>
                    
                    <form method="POST" action="{{ route('admin.pesticide-shops.update_status', $pesticideShop) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-2">
                            <button type="submit" name="status" value="approved"
                                class="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition shadow-md shadow-emerald-700/10 text-sm">
                                Approve Application
                            </button>
                        </div>
                        
                        <div class="pt-2 border-t border-slate-100">
                            <label for="rejection_reason" class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Rejection Reason</label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="3" placeholder="Provide explanation details if rejecting this shop request..."
                                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('rejection_reason') }}</textarea>
                        </div>
                        
                        <button type="submit" name="status" value="rejected"
                            class="w-full py-3 border border-red-200 text-red-700 hover:bg-red-50 font-bold rounded-xl transition text-sm">
                            Reject Application
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection