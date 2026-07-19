@extends('shop.layouts.root')

@section('title', 'Pesticide Shop Application')
@section('breadcumb')
    <a href="{{ route('shop.dashboard') }}" class="hover:underline">{{ __('messages.shop.dashboard') }}</a>
    <span>&middot;</span>
    <span>Pesticide Shop Application</span>
@endsection

@section('content')
    <div class="w-[100%] max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-black text-slate-900 mb-1">ပိုးသတ်ဆေးလုပ်ငန်းလိုင်စင်လျှောက်လွှာ (ပုံစံ - ၇)</h1>
        <p class="text-sm text-slate-500 mb-6">Please fill out the details below carefully to submit your application to the Agriculture Office.</p>
        
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-sm text-red-800">
                <p class="font-bold mb-2">ကျေးဇူးပြု၍ အောက်ပါအချက်အလက်များကို ပြန်လည်စစ်ဆေးပေးပါ -</p>
                <ul class="list-disc pl-5 space-y-1 text-xs text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('shop.storeLicenseApplication') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-base font-black text-emerald-800 border-l-4 border-emerald-600 pl-2">၁။ လျှောက်ထားသူ အချက်အလက်</h3>
                
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Name (လျှောက်ထားသူအမည်)</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="township" class="block text-sm font-bold text-slate-700 mb-1">Township (မြို့နယ်)</label>
                        <input type="text" name="township" id="township" value="{{ old('township') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">NRC Number (နိုင်ငံသားစိစစ်ရေးကတ်ပြားအမှတ်)</label>
                    <div class="flex flex-wrap gap-2 items-center">
                        <select id="state-number" class="rounded-xl border border-slate-200 px-3 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                            @foreach (['၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉', '၁၀', '၁၁', '၁၂', '၁၃', '၁၄'] as $nrc_code)
                                <option value="{{ $nrc_code }}" {{ old('state_number', '၁၂') === $nrc_code ? 'selected' : '' }}>{{ $nrc_code }}</option>
                            @endforeach
                        </select>
                        <span class="text-slate-400">/</span>
                        
                        <select id="district" class="rounded-xl border border-slate-200 px-3 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500 outline-none min-w-[120px]" data-old-value="{{ old('district_old_val') }}">
                            <option value="" selected>{{ __('messages.shop.select_nrc_code_first') }}</option>
                        </select>
                        <input type="hidden" name="district_old_val" id="district_old_val" value="{{ old('district_old_val') }}">
                        
                        <select id="naing" class="rounded-xl border border-slate-200 px-3 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                            @foreach(['နိုင်', 'ပြု', 'ဧည့်', 'သာ'] as $status_type)
                                <option value="{{ $status_type }}" {{ old('naing_old_val') === $status_type ? 'selected' : '' }}>({{ $status_type }})</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="naing_old_val" id="naing_old_val" value="{{ old('naing_old_val', 'နိုင်') }}">

                        <input type="text" id="nrc_number" placeholder="၁၂၃၄၅၆" value="{{ old('nrc_serial_val') }}" required class="flex-1 min-w-[150px] rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <input type="hidden" name="nrc_serial_val" id="nrc_serial_val" value="{{ old('nrc_serial_val') }}">
                        
                        <input type="hidden" name="nrc" id="nrc" value="{{ old('nrc') }}">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="education" class="block text-sm font-bold text-slate-700 mb-1">Education/Qualifications (ပညာအရည်အချင်း)</label>
                        <input type="text" name="education" id="education" value="{{ old('education') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="stable_address" class="block text-sm font-bold text-slate-700 mb-1">Permanent Address (အမြဲတမ်းနေရပ်လိပ်စာ)</label>
                        <input type="text" name="stable_address" id="stable_address" value="{{ old('stable_address') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-base font-black text-emerald-800 border-l-4 border-emerald-600 pl-2">၂။ ဆိုင်နှင့် အဆောက်အအုံဆိုင်ရာ အချက်အလက်များ</h3>
                
                <div>
                    <label for="requested_selling_address" class="block text-sm font-bold text-slate-700 mb-1">Shop / Storage Address (ပိုးသတ်ဆေးသိုလှောင်မည့်/ရောင်းချမည့်နေရာ)</label>
                    <textarea name="requested_selling_address" id="requested_selling_address" rows="2" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('requested_selling_address') }}</textarea>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="building_type" class="block text-sm font-bold text-slate-700 mb-1">Building Structural Type (အဆောက်အအုံအမျိုးအစား)</label>
                        <input type="text" name="building_type" id="building_type" placeholder="အမိုး/အကာ/အခင်း" value="{{ old('building_type') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="building_area" class="block text-sm font-bold text-slate-700 mb-1">Building Dimensions (အကျယ်အဝန်း)</label>
                        <input type="text" name="building_area" id="building_area" placeholder="ဥပမာ - ၁၅ ပေ x ပေ ၂၀" value="{{ old('building_area') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="from_restaurant_distance" class="block text-sm font-bold text-slate-700 mb-1">Distance From Food Shops/Pharmacies (အကွာအဝေးဖော်ပြချက်)</label>
                        <input type="text" name="from_restaurant_distance" id="from_restaurant_distance" value="{{ old('from_restaurant_distance') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="retail_or_wholesale" class="block text-sm font-bold text-slate-700 mb-1">Business Operation Type (လုပ်ငန်းအမျိုးအစား)</label>
                        <select name="retail_or_wholesale" id="retail_or_wholesale" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="retail" {{ old('retail_or_wholesale') === 'retail' ? 'selected' : '' }}>Retail (လက်လီ)</option>
                            <option value="wholesale" {{ old('retail_or_wholesale') === 'wholesale' ? 'selected' : '' }}>Wholesale (လက်ကား)</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-start bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="has_emergency_preparedness_plan" id="has_emergency_preparedness_plan" value="1" {{ old('has_emergency_preparedness_plan') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="has_emergency_preparedness_plan" class="font-bold text-slate-800">Emergency Preparedness Plan Installed</label>
                        <p class="text-slate-500 text-xs">ဘေးအန္တရာယ်ကြိုတင်ကာကွယ်ရေးနှင့် သန့်ရှင်းရေးဆိုင်ရာ ပြင်ဆင်မှုများ ရှိပါသည်။</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-6">
                <h3 class="text-base font-black text-emerald-800 border-l-4 border-emerald-600 pl-2">၃။ ပတ်ဝန်းကျင်သဘောတူညီချက်များ (Surrounding Agreements)</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Village (ရွာ)</label>
                        <input type="text" name="surrounding_agreements[location][village]" value="{{ old('surrounding_agreements.location.village') }}" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Village Tract (ကျေးရွာအုပ်စု)</label>
                        <input type="text" name="surrounding_agreements[location][village_tract]" value="{{ old('surrounding_agreements.location.village_tract') }}" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Township (မြို့နယ်)</label>
                        <input type="text" name="surrounding_agreements[location][township]" value="{{ old('surrounding_agreements.location.township') }}" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Region/State (တိုင်း/ပြည်နယ်)</label>
                        <input type="text" name="surrounding_agreements[location][region_state]" value="{{ old('surrounding_agreements.location.region_state') }}" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">ပတ်ဝန်းကျင် နယ်နိမိတ်ဆိုင်ရာ ထောက်ခံသူများ</p>
                    
                    @foreach(['store_front' => 'အရှေ့ဘက် (Store Front)', 'store_end' => 'အနောက်ဘက် (Store End)', 'store_south' => 'တောင်ဘက် (Store South)', 'store_north' => 'မြောက်ဘက် (Store North)'] as $key => $label)
                        <div class="p-4 border border-slate-100 bg-slate-50/30 rounded-2xl space-y-3">
                            <span class="text-sm font-bold text-slate-800 block">{{ $label }}</span>
                            <div class="grid sm:grid-cols-3 gap-3">
                                <div>
                                    <input type="text" name="surrounding_agreements[boundaries][{{ $key }}][name]" value="{{ old("surrounding_agreements.boundaries.{$key}.name") }}" placeholder="အမည်" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <input type="text" name="surrounding_agreements[boundaries][{{ $key }}][nrc]" value="{{ old("surrounding_agreements.boundaries.{$key}.nrc") }}" placeholder="မှတ်ပုံတင်အမှတ်" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Signature (ထောက်ခံသူ လက်မှတ်)</label>
                                    <input type="file" name="surrounding_agreements_signatures[{{ $key }}]" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 cursor-pointer">
                                    <p class="text-[10px] text-amber-600 mt-1">※ Validation failure triggers: leave blank to retain your original file upload safely.</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-base font-black text-emerald-800 border-l-4 border-emerald-600 pl-2">၄။ ပူးတွဲတင်ပြရန် စာရွက်စာတမ်းများ (Attachments)</h3>
                
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach([
                        'card_front' => 'သင်တန်းဆင်းကတ်ပြား - အရှေ့ဖက် (Card Front)',
                        'card_back' => 'သင်တန်းဆင်းကတ်ပြား - အနောက်ဖက် (Card Back)',
                        'certificate' => 'သင်တန်းဆင်းလက်မှတ် (Certificate)',
                        'ward_approval' => 'ရပ်ကွက်ထောက်ခံစာ (Ward Approval)'
                    ] as $fileKey => $fileLabel)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex flex-col justify-between space-y-3">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">{{ $fileLabel }}</label>
                                <input type="file" name="attachments[{{ $fileKey }}]" accept="image/*" 
                                       class="previewable-input w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" 
                                       data-target="preview-{{ $fileKey }}">
                                <p class="text-[10px] text-slate-400 mt-1">Re-upload only if modifying.</p>
                            </div>
                            <div id="preview-{{ $fileKey }}" class="hidden border border-slate-200 rounded-xl overflow-hidden bg-white max-h-32 flex items-center justify-center p-1">
                                <img src="" alt="Preview" class="max-h-28 w-auto object-contain">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-3">
                <h3 class="text-base font-black text-emerald-800 border-l-4 border-emerald-600 pl-2">၅။ လျှောက်ထားသူ၏ လက်မှတ် (Signature)</h3>
                <div class="max-w-xs">
                    <input type="file" name="signature" id="signature" accept="image/*" class="previewable-input w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" data-target="preview-main-sig">
                    <div id="preview-main-sig" class="hidden mt-3 border border-slate-200 rounded-xl overflow-hidden bg-white max-h-32 flex items-center justify-center p-1">
                        <img src="" alt="Signature Preview" class="max-h-28 w-auto object-contain">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-700/20 text-center">
                လိုင်စင်လျှောက်လွှာ တင်သွင်းမည်
            </button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const nrc_formats = @json($nrc_formats);
        const stateNumberSelect = document.getElementById('state-number');
        const districtSelect = document.getElementById('district');
        const naingSelect = document.getElementById('naing');
        const nrcInput = document.getElementById('nrc_number');
        const hiddenNrcInput = document.getElementById('nrc');
    
        const oldDistrictTracker = document.getElementById('district_old_val');
        const oldNaingTracker = document.getElementById('naing_old_val');
        const oldSerialTracker = document.getElementById('nrc_serial_val');

        function mmToEn(mm) {
            const mmNumbers = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
            return mm.split('').map(char => {
                const index = mmNumbers.indexOf(char);
                return index !== -1 ? index : char;
            }).join('');
        }

        function enToMm(en) {
            if (!en) return '';
            const mmNumbers = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
            return en.split('').map(char => {
                const num = parseInt(char, 10);
                return (!isNaN(num) && char.trim() !== '') ? mmNumbers[num] : char;
            }).join('');
        }

        function updateFullNrcValue() {
            const state = stateNumberSelect.value;
            const district = districtSelect.value;
            const naing = naingSelect.value;
            const serial = nrcInput.value.trim();
            oldDistrictTracker.value = district;
            oldNaingTracker.value = naing;
            oldSerialTracker.value = serial;

            if (state && district && naing && serial) {
                hiddenNrcInput.value = `${state}/${district}(${naing})${serial}`;
            } else {
                hiddenNrcInput.value = '';
            }
        }

        function populateDistricts() {
            const selectedNrcCode = mmToEn(stateNumberSelect.value);
            const districts = nrc_formats.districts.filter(d => d.nrc_code === selectedNrcCode);
            
            districtSelect.innerHTML = '';
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.name_mm;
                option.textContent = district.name_mm;
                districtSelect.appendChild(option);
            });

            const cachedTarget = districtSelect.getAttribute('data-old-value');
            if (cachedTarget) {
                districtSelect.value = cachedTarget;
            }
            updateFullNrcValue();
        }


        document.querySelectorAll('.previewable-input').forEach(input => {
            input.addEventListener('change', function() {
                const targetId = this.getAttribute('data-target');
                const container = document.getElementById(targetId);
                const img = container.querySelector('img');
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        img.src = e.target.result;
                        container.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    container.classList.add('hidden');
                }
            });
        });

        stateNumberSelect.addEventListener('change', () => {
            districtSelect.removeAttribute('data-old-value'); 
            populateDistricts();
        });
        districtSelect.addEventListener('change', updateFullNrcValue);
        naingSelect.addEventListener('change', updateFullNrcValue);
        nrcInput.addEventListener('input', function () {
            this.value = enToMm(this.value);
            updateFullNrcValue();
        });

        document.addEventListener('DOMContentLoaded', () => {
            populateDistricts();
        });
    </script>
@endsection