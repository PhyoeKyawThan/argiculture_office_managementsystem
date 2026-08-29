@extends('admin.layouts.root')

@section('title', $pesticideShop->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pesticide-shops.index') }}" class="text-sm font-bold text-emerald-700 flex items-center gap-1">
            &larr; {{ __('messages.common.back_to_list') }}
        </a>
        <span class="text-slate-300 mx-2">|</span>
        <form action="{{ route('admin.pesticide-shops.delete', $pesticideShop) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm font-bold text-red-600 hover:underline" data-confirm data-confirm-message="@json(__('messages.shop_reg.confirm_delete'))" data-confirm-title="@json(__('messages.common.delete'))">{{ __('messages.common.delete') }}</button>
        </form>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-6">
                    <div>
                        <h1 class="text-2xl font-black text-slate-900">{{ $pesticideShop->name }}</h1>
                        <p class="text-slate-500 text-sm mt-1">လျှောက်ထားသူအမည်- <span class="font-bold text-slate-800">{{ $pesticideShop->name }}</span></p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider
                        @if($pesticideShop->status === 'approved') bg-emerald-100 text-emerald-800
                        @elseif($pesticideShop->status === 'rejected') bg-red-100 text-red-800
                        @else bg-amber-100 text-amber-800 @endif">
                        {{  __('messages.pesticide_shops.status_' . $pesticideShop->status) }}
                    </span>
                </div>

                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">၁။ လျှောက်ထားသူနှင့် ဆိုင်အချက်အလက်</h3>
                <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm border-b border-slate-100 pb-6">
                    <div>
                        <dt class="font-bold text-slate-400">မှတ်ပုံတင်နံပါတ်</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->nrc }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">မြို့နယ်</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->township }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">ပညာအရည်အချင်း</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->education }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">လုပ်ငန်းအမျိူးအစား</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5 capitalize">{{ $pesticideShop->retail_or_wholesale }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="font-bold text-slate-400">အမြဲတမ်းနေရပ်လိပ်စာ</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->stable_address }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="font-bold text-slate-400">ရောင်းချမည့်နေရာလိပ်စာ</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->requested_selling_address }}</dd>
                    </div>
                </dl>

                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mt-6 mb-3">၂။ ဆိုင်အဆောက်အအုံဖွဲ့စည်းမှု တည်ဆောက်ချက်</h3>
                <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div>
                        <dt class="font-bold text-slate-400">အဆောက်အအုံအမျိုးအစား</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->building_type }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">အဆောက်အအုံအကျယ်အဝန်း</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->building_area }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">စား‌သောက်ဆိုင်နှင့်ဆေးဆိုင်များမှအကွာအဝေးဖော်ပြချက်</dt>
                        <dd class="font-semibold text-slate-800 mt-0.5">{{ $pesticideShop->from_restaurant_distance }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">ဘေးအန္တရာယ်ကြိုတင်ကာကွယ်ရေးပြင်ဆင်ထားမှု့များရှိပါသည်။</dt>
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
                <h3 class="text-base font-black text-slate-900">၃။ ပိုးသတ်ဆေးအမျိုးအစားများ</h3>

                @php
                    $items = is_string($pesticideShop->items) ? json_decode($pesticideShop->items, true) : $pesticideShop->items;
                @endphp

                @if(!empty($items))
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-slate-200 rounded-xl overflow-hidden">
                            <thead class="bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-3 py-2 text-left">#</th>
                                    <th class="px-3 py-2 text-left">ပိုးသတ်ဆေးအမည်</th>
                                    <th class="px-3 py-2 text-left">ဖော်မြူလာ</th>
                                    <th class="px-3 py-2 text-left">ပိုးသတ်ဆေးအမျိုးအစား</th>
                                    <th class="px-3 py-2 text-left">ထုတ်ပိုးမှူ အရွယ်အစား</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($items as $index => $item)
                                    <tr>
                                        <td class="px-3 py-2 text-slate-500">{{ $index + 1 }}</td>
                                        <td class="px-3 py-2 font-semibold text-slate-800">{{ $item['name'] ?? '—' }}</td>
                                        <td class="px-3 py-2 text-slate-600">{{ $item['formula'] ?? '—' }}</td>
                                        <td class="px-3 py-2 text-slate-600">{{ $item['type'] ?? '—' }}</td>
                                        <td class="px-3 py-2 text-slate-600">{{ $item['capacity'] ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic">No pesticide items provided.</p>
                @endif
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900">၄။ ပူးတွဲတင်ပြရန် စာရွက်စာတမ်းများ </h3>

                @php
                    $attachments = is_string($pesticideShop->attachments)
                        ? json_decode($pesticideShop->attachments, true)
                        : $pesticideShop->attachments;
                @endphp

                <div class="grid sm:grid-cols-2 gap-4">
                    @if($pesticideShop->surrounding_agreement_attachment)
                        <div class="border border-slate-100 rounded-2xl p-4 bg-slate-50/50 flex flex-col justify-between space-y-3">
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">surrounding_agreement_attachment</span>
                                <span class="block text-sm font-bold text-slate-800 mt-0.5">ပတ်ဝန်းကျင်သဘောတူညီချက်</span>
                            </div>
                            <div class="relative border border-slate-200 rounded-xl bg-white overflow-hidden group">
                                <img src="{{ asset('storage/' . $pesticideShop->surrounding_agreement_attachment) }}" alt="Surrounding Agreement" class="w-full h-32 object-contain p-2">
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <a href="{{ asset('storage/' . $pesticideShop->surrounding_agreement_attachment) }}" target="_blank" class="px-3 py-1.5 bg-white text-slate-900 font-bold text-xs rounded-xl shadow-md hover:bg-slate-100">
                                        Open Full File &nearr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @foreach([
                        'card_front' => 'သင်တန်းဆင်းကတ်ပြား (အရှေ့)',
                        'card_back' => 'သင်တန်းဆင်းကတ်ပြား (အနောက်)',
                        'certificate' => 'သင်တန်းဆင်းလက်မှတ် ',
                        'ward_approval' => 'ရပ်ကွက်ထောက်ခံစာ'
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
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-black text-slate-900">၅။ လျှောက်ထားသူ၏ လက်မှတ် </h3>
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
            <div class="flex justify-between flex-wrap gap-4 rounded-3xl border border-red-200 bg-blue-50 p-6 text-sm text-red-800 shadow-sm">
                <a class="p-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition shadow-md shadow-blue-500/10 text-sm" href="{{ route('admin.pesticide-shops.download', [$pesticideShop->id, 'format' => 'pdf']) }}">{{ __('messages.pesticide_shops.download') }} (.pdf)</a>
                {{-- <a class="p-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition shadow-md shadow-blue-500/10 text-sm" href="{{ route('admin.pesticide-shops.download', [$pesticideShop->id, 'format' => 'docx']) }}">
                    {{ __('messages.pesticide_shops.download') }} (.docx)
                </a> --}}
                {{-- <a class="p-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition shadow-md shadow-blue-500/10 text-sm" href="{{ route('admin.pesticide-shops.download_agreements', [$pesticideShop->id, 'format' => 'docx']) }}">
                    {{ __('messages.pesticide_shops.download_agreements') }} (.docx)
                </a> --}}
                {{-- <a class="p-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition shadow-md shadow-blue-500/10 text-sm" href="{{ route('admin.pesticide-shops.download_agreements', [$pesticideShop->id, 'format' => 'pdf']) }}">
                    {{ __('messages.pesticide_shops.download_agreements') }} (.pdf)
                </a> --}}
                 <a class="p-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition shadow-md shadow-blue-500/10 text-sm" href="{{ route('admin.pesticide-shops.download_license', [$pesticideShop->id]) }}">
                    {{ __('messages.pesticide_shops.download_license') }} (.pdf)
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
                    <h2 class="text-lg font-black text-slate-900">လျှောက်လွှာပြန်လည်ဆန်းစစ်ခြင်း</h2>
                    <p class="text-xs text-slate-400">Evaluate application materials, attachments, and neighborhood validations before verifying approval status.</p>
                    
                    <form method="POST" action="{{ route('admin.pesticide-shops.update_status', $pesticideShop) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-2">
                            <button type="submit" name="status" value="approved"
                                class="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition shadow-md shadow-emerald-700/10 text-sm">
                              အတည်ပြုသည်
                            </button>
                        </div>
                        
                        <div class="pt-2 border-t border-slate-100">
                            <label for="rejection_reason" class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">ပယ်ဖျက်ရသည့်အကြောင်းရင်း</label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="3" placeholder="ပယ်ဖျက်ရသည့်အကြောင်းအရင်းကိုရေးသားပါ။"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('rejection_reason', $pesticideShop->rejection_reason ?? '') }}</textarea>
                        </div>
                        
                        <button type="submit" name="status" value="rejected"
                            class="w-full py-3 border border-red-200 text-red-700 hover:bg-red-50 font-bold rounded-xl transition text-sm">
                          ပယ်ဖျက်ရန်
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection