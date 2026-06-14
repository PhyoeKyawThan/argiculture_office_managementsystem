@extends(auth()->check() && auth()->user()->isFarmer() ? 'farmer.layouts.app' : 'landing.layout')

@section('title', __('messages.content.modules.'.$module.'.label'))

@section('content')
    <section class="max-w-5xl mx-auto px-0 sm:px-0 py-4 sm:py-6">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.content.modules.'.$module.'.label') }}</h1>
            <p class="text-slate-600 mt-2">{{ __('messages.content.modules.'.$module.'.description') }}</p>
        </div>

        <x-content-module-nav
            context="page"
            :modules="$enabledModules"
            :current-module="$module"
            :current-sub-type="$subType"
        />

        <div class="grid sm:grid-cols-2 gap-6">
            @forelse($announcements as $article)
                <article class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                    @if($article->featured_image_path)
                        <a href="{{ route('news.show', $article) }}">
                            <img src="{{ $article->featuredImageUrl() }}" alt="" class="w-full h-44 object-cover">
                        </a>
                    @endif
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex flex-wrap gap-2 mb-2">
                            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-600">{{ __('messages.content.modules.'.$article->module.'.label') }}</span>
                            @if($article->sub_type)
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">{{ __('messages.content.sub_types.'.$article->sub_type) }}</span>
                            @endif
                        </div>
                        <h2 class="text-lg font-bold text-slate-900 mb-2">
                            <a href="{{ route('news.show', $article) }}" class="hover:text-emerald-800">{{ $article->title }}</a>
                        </h2>
                        <p class="text-sm text-slate-600 line-clamp-3 flex-1">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 140) }}</p>
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-emerald-50">
                            <time class="text-xs text-slate-500">{{ $article->published_at?->format('M j, Y') }}</time>
                            <a href="{{ route('news.show', $article) }}" class="text-sm font-bold text-emerald-700">{{ __('messages.common.read_more') }}</a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="col-span-2 text-center text-slate-500 py-12 bg-white rounded-2xl border border-emerald-100">{{ __('messages.announcements.no_public_records') }}</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $announcements->links() }}</div>
    </section>
@endsection
