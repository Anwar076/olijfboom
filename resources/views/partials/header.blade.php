<header class="bg-slate-50/95 backdrop-blur-sm border-b border-slate-200">
    <div class="container mx-auto px-4 py-4">
        <a href="{{ route('home') }}" class="hover:opacity-80 transition-opacity inline-block">
            <img src="{{ asset('images/logo.png') }}" alt="Islamitisch Centrum Barendrecht" class="h-auto w-auto max-w-[215px]">
        </a>
    </div>
</header>

@if (request()->routeIs('home'))
    <div class="nav-gradient sticky top-0 z-50" data-home-nav>
        <div class="container mx-auto px-3 sm:px-4">
            <nav class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 py-2 sm:py-4 text-white">
                <div class="hidden sm:block flex-1 shrink-0 min-w-0" aria-hidden="true"></div>
                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-6 shrink-0 order-2 sm:order-none">
                    <button type="button" data-section-id="boom" class="text-sm sm:text-base font-semibold transition-opacity text-white opacity-90 hover:opacity-100 py-1.5 px-2 sm:py-0 sm:px-0">Boom</button>
                    <button type="button" data-section-id="doel" class="text-sm sm:text-base font-semibold transition-opacity text-white opacity-90 hover:opacity-100 py-1.5 px-2 sm:py-0 sm:px-0">Doel</button>
                    <button type="button" data-section-id="teams" class="text-sm sm:text-base font-semibold transition-opacity text-white opacity-90 hover:opacity-100 py-1.5 px-2 sm:py-0 sm:px-0">Teams</button>
                    <button type="button" data-section-id="doneer" class="text-sm sm:text-base font-semibold transition-opacity text-white opacity-90 hover:opacity-100 py-1.5 px-2 sm:py-0 sm:px-0">Doneer</button>
                    <button type="button" data-section-id="faq" class="text-sm sm:text-base font-semibold transition-opacity text-white opacity-90 hover:opacity-100 py-1.5 px-2 sm:py-0 sm:px-0">FAQ</button>
                </div>
                <div class="flex flex-1 sm:flex-1 items-center justify-center sm:justify-end gap-2 sm:gap-3 shrink-0 order-1 sm:order-none py-1 sm:py-0">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 sm:px-4 rounded-lg text-sm sm:text-base font-semibold bg-white/20 hover:bg-white/30 text-white border border-white/40 transition-colors whitespace-nowrap">
                            Dashboard
                        </a>
                    @else
                        <button type="button" data-scroll-doneer class="px-3 py-2 sm:px-4 rounded-lg text-sm sm:text-base font-semibold bg-gold text-slate-900 hover:bg-amber-400 border border-amber-500/50 transition-colors shadow-sm whitespace-nowrap">
                            Doneer nu
                        </button>
                        <a href="{{ route('login') }}" class="px-3 py-2 sm:px-4 rounded-lg text-sm sm:text-base font-semibold text-white border border-white/50 hover:bg-white/10 transition-colors whitespace-nowrap">
                            Inloggen
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </div>

    <section class="px-4 pt-6 sm:pt-8 pb-8">
        <div class="showcase-rail" data-showcase-rail>
            <div class="showcase-rail__track">
                @for ($loopIndex = 0; $loopIndex < 2; $loopIndex++)
                    @foreach ($homeShowcaseMedia as $index => $mediaItem)
                        <div class="showcase-rail__item" {{ $loopIndex === 1 ? 'aria-hidden=true' : '' }}>
                            @if (($mediaItem['type'] ?? 'image') === 'video')
                                <video
                                    src="{{ $mediaItem['url'] }}"
                                    class="showcase-rail__media"
                                    muted
                                    loop
                                    playsinline
                                    preload="metadata"
                                    data-autoplay-on-view
                                ></video>
                            @else
                                <img
                                    src="{{ $mediaItem['url'] }}"
                                    alt="{{ $loopIndex === 0 ? 'Sfeerfoto ' . ($index + 1) : '' }}"
                                    class="showcase-rail__media"
                                >
                            @endif
                        </div>
                    @endforeach
                @endfor
            </div>
        </div>
    </section>
@endif
