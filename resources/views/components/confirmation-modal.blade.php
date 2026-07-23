<div id="confirmModal" class="fixed inset-0 z-[200] hidden" aria-hidden="true">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0" id="confirmModalBackdrop"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-emerald-50 rounded-2xl shadow-2xl border border-emerald-100 w-full max-w-md transform scale-95 opacity-0 transition-all duration-200 ease-out" id="confirmModalPanel">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 rounded-full bg-red-100 text-red-700 shrink-0">
                        <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-black text-emerald-900" id="confirmModalTitle">{{ __('messages.common.confirm_action') }}</h3>
                </div>
                <p class="text-sm text-slate-600 mb-6" id="confirmModalMessage">{{ __('messages.common.confirm_message_default') }}</p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" id="confirmModalCancel"
                        class="px-4 py-2 rounded-xl border border-emerald-200 text-emerald-900 font-bold hover:bg-emerald-50 transition text-sm">
                        {{ __('messages.common.cancel') }}
                    </button>
                    <button type="button" id="confirmModalConfirm"
                        class="px-4 py-2 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition text-sm">
                        {{ __('messages.common.delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
