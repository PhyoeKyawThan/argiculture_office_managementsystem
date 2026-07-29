@php $s = $staff ?? null; @endphp

<div class="space-y-8">
    <section>
        <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.staff.personal') }}</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="personal_no" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.personal_no') }}</label>
                <input type="text" name="personal_no" id="personal_no" value="{{ old('personal_no', $s?->personal_no) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.full_name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name', $s?->name) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label for="gender" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.gender') }}</label>
                <select name="gender" id="gender" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="male" @selected(old('gender', $s?->gender) === 'male')>{{ __('messages.staff.male') }}</option>
                    <option value="female" @selected(old('gender', $s?->gender) === 'female')>{{ __('messages.staff.female') }}</option>
                </select>
            </div>
            <div>
                <label for="date_of_birth" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.dob') }}</label>
                <input type="date" name="date_of_birth" id="date_of_birth"
                    value="{{ old('date_of_birth', $s?->date_of_birth?->format('Y-m-d')) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div class="sm:col-span-2">
                <label for="education_level" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.education_level') }}</label>
                <input type="text" name="education_level" id="education_level" value="{{ old('education_level', $s?->education_level) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_married" value="1" @checked(old('is_married', $s?->is_married ?? false))
                        class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    {{ __('messages.staff.married') }}
                </label>
            </div>
        </div>
    </section>

    <section>
        <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.staff.career') }}</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="first_joining_date" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.first_joining_date') }}</label>
                <input type="date" name="first_joining_date" id="first_joining_date"
                    value="{{ old('first_joining_date', $s?->first_joining_date?->format('Y-m-d')) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label for="assigned_position" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.assigned_position') }}</label>
                <input type="text" name="assigned_position" id="assigned_position"
                    value="{{ old('assigned_position', $s?->assigned_position) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>
    </section>

    <section>
        <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.staff.current_assignment') }}</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="current_position" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.current_position') }}</label>
                <input type="text" name="current_position" id="current_position"
                    value="{{ old('current_position', $s?->current_position) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label for="current_position_joining_date" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.current_position_joining_date') }}</label>
                <input type="date" name="current_position_joining_date" id="current_position_joining_date"
                    value="{{ old('current_position_joining_date', $s?->current_position_joining_date?->format('Y-m-d')) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label for="current_region" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.current_region') }}</label>
                <input type="text" name="current_region" id="current_region"
                    value="{{ old('current_region', $s?->current_region) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label for="current_office" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.current_office') }}</label>
                <input type="text" name="current_office" id="current_office"
                    value="{{ old('current_office', $s?->current_office) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label for="current_branch" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.current_branch') }}</label>
                <input type="text" name="current_branch" id="current_branch"
                    value="{{ old('current_branch', $s?->current_branch) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label for="current_salary" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.staff.current_salary') }}</label>
                <input type="number" name="salary" id="current_salary"
                    value="{{ old('salary', $s?->salary) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>
    </section>
</div>
