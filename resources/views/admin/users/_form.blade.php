@php $userModel = $user ?? null; @endphp
<div class="grid gap-4 max-w-lg">
    <div>
        <label for="name" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.users.name_col') }}</label>
        <input type="text" name="name" id="name" value="{{ old('name', $userModel?->name) }}" required
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
    </div>
    <div>
        <label for="email" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.auth.email') }}</label>
        <input type="email" name="email" id="email" value="{{ old('email', $userModel?->email) }}" required
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
    </div>
    <div>
        <label for="role" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.users.role') }}</label>
        <select name="role" id="role" required
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            @foreach($roles as $role)
                <option value="{{ $role }}" @selected(old('role', $userModel?->role) === $role)>{{ __('messages.roles.'.$role) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="password" class="block text-sm font-bold text-slate-700 mb-1">
            {{ __('messages.users.password') }} @if($userModel)<span class="font-normal text-slate-500">{{ __('messages.users.password_leave_blank') }}</span>@endif
        </label>
        <input type="password" name="password" id="password" {{ $userModel ? '' : 'required' }}
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.users.confirm_password') }}</label>
        <input type="password" name="password_confirmation" id="password_confirmation" {{ $userModel ? '' : 'required' }}
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
    </div>
</div>
