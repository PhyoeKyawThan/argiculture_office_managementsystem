@if($u && $u->isBackOffice())
    <div class="relative" id="notificationMenuWrap">
        <button type="button" id="notificationMenuBtn"
            class="relative p-2 rounded-lg hover:bg-emerald-800 transition-all"
            title="{{ __('messages.notifications.title') }}"
            aria-label="{{ __('messages.notifications.title') }}">
            <i data-lucide="bell" class="w-5 h-5"></i>
            @if(($unreadNotificationCount ?? 0) > 0)
                <span class="absolute -top-0.5 -right-0.5 min-w-[1.125rem] h-[1.125rem] px-1 rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center">
                    {{ $unreadNotificationCount > 9 ? '9+' : $unreadNotificationCount }}
                </span>
            @endif
        </button>
        <div id="notificationMenu"
            class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white text-slate-700 rounded-2xl shadow-2xl border border-emerald-50 overflow-hidden z-50">
            <div class="flex items-center justify-between px-4 py-3 border-b border-emerald-50 bg-emerald-50/50">
                <span class="text-sm font-black text-emerald-900">{{ __('messages.notifications.title') }}</span>
                @if(($unreadNotificationCount ?? 0) > 0)
                    <form method="POST" action="{{ route('admin.notifications.read-all') }}">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">
                            {{ __('messages.notifications.mark_all_read') }}
                        </button>
                    </form>
                @endif
            </div>
            <div class="max-h-80 overflow-y-auto">
                @forelse($unreadNotifications ?? [] as $notification)
                    <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 hover:bg-emerald-50 border-b border-emerald-50/80 transition">
                            <p class="text-sm font-bold text-slate-900 line-clamp-2">{{ $notification->data['message'] ?? '' }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </button>
                    </form>
                @empty
                    <p class="px-4 py-8 text-sm text-slate-500 text-center">{{ __('messages.notifications.empty') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endif
