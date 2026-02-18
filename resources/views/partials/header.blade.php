<header class="bg-slate-50/95 backdrop-blur-sm border-b border-slate-200">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/logo.png') }}" alt="Islamitisch Centrum Barendrecht" class="h-auto w-auto max-w-[215px]">
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary bg-gold text-slate-900 border border-gold hover:bg-gold-dark">
                        Dashboard
                    </a>
                @else
                    @if (request()->routeIs('home'))
                        <button
                            type="button"
                            data-scroll-doneer
                            class="hidden sm:inline-flex btn btn-secondary bg-gold text-slate-900 border border-gold hover:bg-gold-dark"
                        >
                            Doneer nu
                        </button>
                    @endif
                    <a
                        href="{{ route('login') }}"
                        class="btn btn-primary bg-white text-slate-900 border border-slate-300 hover:bg-slate-100"
                    >
                        Inloggen
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

@if (request()->routeIs('home'))
    @php
        $tickerText = $homeNewsTickerText ?? 'Dit is dummy nieuwscontent: sponsorloop start om 10:00 uur, inschrijvingen zijn nog open en deel deze actie met je netwerk.';
    @endphp
    <div class="nav-gradient sticky top-0 z-50" data-home-nav>
        <div class="container mx-auto px-4">
            <nav class="flex flex-wrap items-center justify-center gap-6 py-4 text-white">
                <button type="button" data-section-id="boom" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">Boom</button>
                <button type="button" data-section-id="doel" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">Doel</button>
                <button type="button" data-section-id="teams" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">Teams</button>
                <button type="button" data-section-id="doneer" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">Doneer</button>
                <button type="button" data-section-id="faq" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">FAQ</button>
            </nav>
        </div>
    </div>

    <div class="home-news-ticker">
        <div class="container mx-auto px-4">
            <div class="home-news-ticker__viewport" aria-label="Laatste nieuws">
                <div class="home-news-ticker__track">
                    <span class="home-news-ticker__base">{{ $tickerText }}</span>
                    @isset($duaTickerItems)
                        @foreach ($duaTickerItems as $dua)
                            <span class="home-news-ticker__dua">
                                <span class="home-news-ticker__dua-label">Du&#257;-verzoek</span>
                                {{ $dua }}
                            </span>
                        @endforeach
                    @endisset
                    {{-- Duplicate for seamless loop --}}
                    <span class="home-news-ticker__base" aria-hidden="true">{{ $tickerText }}</span>
                    @isset($duaTickerItems)
                        @foreach ($duaTickerItems as $dua)
                            <span class="home-news-ticker__dua" aria-hidden="true">
                                <span class="home-news-ticker__dua-label">Du&#257;-verzoek</span>
                                {{ $dua }}
                            </span>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endif
