@extends('admin.layouts.root')

@section('title', __('messages.users.title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.users.title') }}</h1>
            <p class="text-slate-600 text-sm mt-1">{{ __('messages.users.subtitle') }}</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition text-sm">
            <i data-lucide="plus" class="w-4 h-4"></i> {{ __('messages.users.add') }}
        </a>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.users.search_placeholder') }}"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        <select name="role" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.users.all_roles') }}</option>
            @foreach(\App\Models\User::ROLES as $role)
                <option value="{{ $role }}" @selected(request('role') === $role)>{{ __('messages.roles.'.$role) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm hover:bg-emerald-200 transition">{{ __('messages.common.filter') }}</button>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.users.name_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.users.email_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.users.role') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-right">{{ __('messages.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($users as $user)
                    <tr class="hover:bg-emerald-50/50">
                        <td class="px-4 py-3 font-semibold">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide
                                {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-900' : ($user->role === 'staff' ? 'bg-blue-100 text-blue-900' : 'bg-slate-100 text-slate-700') }}">
                                {{ $user->role_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-emerald-700 font-bold hover:underline">{{ __('messages.common.edit') }}</a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                    onsubmit="return confirm(@json(__('messages.users.confirm_delete')))">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold hover:underline">{{ __('messages.common.delete') }}</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-500">{{ __('messages.users.no_users') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endsection
