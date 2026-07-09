@php
    $u = auth()->user();
@endphp

@if($u)
    <div class="relative" id="shopNotificationMenuWrap">
        <button type="button" id="shopNotificationMenuBtn"
            class="relative p-2 rounded-lg hover:bg-emerald-800 transition-all"
            title="Notifications"
            aria-label="Notifications">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-5 h-5">
                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.172V11a6.002 6.002 0 0 0-5-5.917V4a1 1 0 1 0-2 0v1.083A6.002 6.002 0 0 0 6 11v3.172c0 .53-.21 1.039-.595 1.414L4 17h5" />
                <path d="M9 17a3 3 0 0 0 6 0" />
            </svg>
            @if(($unreadNotificationCount ?? 0) > 0)
                <span class="absolute -top-0.5 -right-0.5 min-w-[1.125rem] h-[1.125rem] px-1 rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center">
                    {{ $unreadNotificationCount > 9 ? '9+' : $unreadNotificationCount }}
                </span>
            @endif
        </button>
        <div id="shopNotificationMenu"
            class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white text-slate-700 rounded-2xl shadow-2xl border border-emerald-50 overflow-hidden z-50">
            <div class="flex items-center justify-between px-4 py-3 border-b border-emerald-50 bg-emerald-50/50">
                <span class="text-sm font-black text-emerald-900">Notifications</span>
                @if(($unreadNotificationCount ?? 0) > 0)
                    <form method="POST" action="{{ route('shop.notifications.read-all') }}">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">
                            Mark all read
                        </button>
                    </form>
                @endif
            </div>
            <div class="max-h-80 overflow-y-auto">
                @forelse($unreadNotifications ?? [] as $notification)
                    <form method="POST" action="{{ route('shop.notifications.read', $notification->id) }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 hover:bg-emerald-50 border-b border-emerald-50/80 transition">
                            <p class="text-sm font-bold text-slate-900 line-clamp-2">{{ $notification->data['message'] ?? '' }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </button>
                    </form>
                @empty
                    <p class="px-4 py-8 text-sm text-slate-500 text-center">No unread notifications.</p>
                @endforelse
            </div>
        </div>
    </div>
@endif