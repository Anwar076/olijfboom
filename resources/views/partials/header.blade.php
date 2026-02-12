<header class="bg-slate-50/95 backdrop-blur-sm border-b border-slate-200">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/logo.png') }}" alt="Islamitisch Centrum Barendrecht" class="h-auto w-auto max-w-[215px]">
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Dashboard</a>
                @else
                    @if (request()->routeIs('home'))
                        <button type="button" data-scroll-doneer class="hidden sm:inline-flex btn btn-primary">
                            Doneer nu
                        </button>
                    @endif
                    <a href="{{ route('login') }}" class="btn btn-secondary">Inloggen</a>
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
        <div class="w-full px-4">
            <nav class="flex w-full flex-wrap items-center justify-center gap-6 py-4 text-white">
                <button type="button" data-section-id="boom" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">Boom</button>
                <button type="button" data-section-id="doel" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">Doel</button>
                <button type="button" data-section-id="teams" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">Teams</button>
                <button type="button" data-section-id="doneer" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">Doneer</button>
                <button type="button" data-section-id="faq" class="font-semibold transition-opacity text-white opacity-90 hover:opacity-100">FAQ</button>
            </nav>
        </div>
    </div>

    <div class="home-news-ticker border-b border-slate-200">
        <div class="w-full px-4">
            <div class="home-news-ticker__viewport" aria-label="Laatste nieuws">
                <div class="home-news-ticker__track">
                    <span>{{ $tickerText }}</span>
                    <span aria-hidden="true">{{ $tickerText }}</span>
                </div>
            </div>
        </div>
    </div>
@endif
