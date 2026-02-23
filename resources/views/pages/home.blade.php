@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')

    <section class="pt-28 pb-16 md:pt-32 md:pb-20 px-4" aria-label="Hero">
        <div class="container mx-auto max-w-4xl flex flex-col items-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-5 title-gradient text-center max-w-4xl leading-tight">
                Ontsteek een Licht voor Moskee Barendrecht
            </h1>
            <p class="text-lg md:text-xl text-slate-700 mb-5 max-w-3xl text-center leading-relaxed">
                Zij leenden ons hun vertrouwen. Nu betalen wij het terug. Samen maken we het Islamitisch Centrum Barendrecht schuldenvrij — voor onze kinderen en de generaties na ons.
            </p>

            <p class="text-base md:text-lg text-slate-600 mb-6 font-medium text-center">
                &euro;{{ number_format($totalRaised, 0, ',', '.') }} van &euro;1.000.000 opgehaald — {{ $lightsActivated }} van 100 lichtjes branden
            </p>

            <div class="hero-cta">
                <div class="hero-cta__inner">
                    <a href="{{ route('teams.create') }}" class="btn btn-primary text-lg min-h-[48px] px-6">
                        Vorm je team
                    </a>
                    <button type="button" data-scroll-doneer class="btn btn-secondary text-lg min-h-[48px] px-6">
                        Doneer nu
                    </button>
                    <!-- <a href="#doneer" class="btn bg-white/20 text-white border-2 border-white/50 hover:bg-white/30 text-lg min-h-[48px] px-6">
                        Doe een dua-verzoek
                    </a> -->
                </div>
            </div>

            @if ($teams->count() > 0)
                <p class="text-slate-600 text-sm md:text-base text-center mb-10">
                    Al {{ $teams->count() }} team{{ $teams->count() === 1 ? '' : 's' }} geregistreerd — doe mee!
                </p>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 w-full max-w-4xl">
                <div class="bg-white rounded-2xl p-5 md:p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-2xl md:text-3xl font-bold text-gold mb-1">
                        &euro;{{ number_format($totalRaised, 0, ',', '.') }}
                    </div>
                    <div class="text-slate-600 text-sm font-medium">Totaal opgehaald</div>
                </div>
                <div class="bg-white rounded-2xl p-5 md:p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-2xl md:text-3xl font-bold text-gold mb-1">
                        {{ $lightsActivated }}
                    </div>
                    <div class="text-slate-600 text-sm font-medium">Lichtjes aan</div>
                </div>
                <div class="bg-white rounded-2xl p-5 md:p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-2xl md:text-3xl font-bold text-gold mb-1">
                        {{ round($progressPercentage) }}%
                    </div>
                    <div class="text-slate-600 text-sm font-medium">Naar doel</div>
                </div>
            </div>
        </div>
    </section>

    @php
        $tickerText = $homeNewsTickerText ?? 'Dit is dummy nieuwscontent: sponsorloop start om 10:00 uur, inschrijvingen zijn nog open en deel deze actie met je netwerk.';
    @endphp
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

    @php
        $progressPercentageRounded = round($progressPercentage);
    @endphp
    @include('pages.partials.olive-tree')

    <section id="doel" class="py-16 md:py-20 px-4 bg-slate-100/50" aria-labelledby="doel-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-10 md:mb-12">
                <h2 id="doel-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Olijfboom van Licht</h2>
                <p class="text-slate-600 text-lg md:text-xl">Over de campagne</p>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-start">
                <div class="lg:col-span-3 order-2 lg:order-1">
                    <div class="bg-white rounded-2xl p-6 md:p-10 border border-slate-200/80 shadow-sm">
                        <p class="text-slate-700 leading-relaxed mb-4">
                            Wat begon als een droom, werd werkelijkheid door de kracht van onze gemeenschap. In Ramadan 2025 nam de Barendrechtse moslimgemeenschap het initiatief voor een eigen islamitisch centrum. In slechts vier dagen doneerde onze gemeenschap &euro;1.500.000 tijdens een historische benefiet.
                        </p>
                        <p class="text-slate-700 leading-relaxed mb-4">
                            Dankzij renteloze leningen van gemeenschapsleden kon het pand aan het Bijdorpplein in december 2025 volledig worden overgenomen — en werd &euro;250.000 aan overdrachtsbelasting voorkomen.
                        </p>
                        <p class="text-slate-700 leading-relaxed mb-4">
                            Nu lossen we deze amanah in. Tijdens Ramadan 2026 halen we samen &euro;1.000.000 op om de leningen terug te betalen aan de mensen die ICB mogelijk hebben gemaakt.
                        </p>
                        <p class="text-slate-700 leading-relaxed">
                            Onze olijfboom heeft 100 lichtjes; elk staat voor &euro;10.000. Wanneer alle branden, is Moskee Barendrecht schuldenvrij — voor nu en voor de generaties na ons. Dit is sadaqah jariyah: bij elk gebed, elke les, elk kind dat hier opgroeit, ontvang jij als donateur ajar van Allah swt.
                        </p>
                    </div>
                </div>
                <div class="lg:col-span-2 order-1 lg:order-2">
                    <div class="rounded-2xl overflow-hidden border border-slate-200/80 shadow-md bg-white">
                        <img src="{{ asset('images/gemeenschap-vrouwen.png') }}" alt="Gemeenschap Barendrecht" class="w-full h-56 md:h-72 object-cover">
                        <div class="p-6">
                            <div class="text-3xl font-bold text-gold mb-1">&euro;1.000.000</div>
                            <div class="text-slate-600 text-sm">Campagnedoel</div>
                            <div class="mt-3 pt-3 border-t border-slate-200">
                                <div class="text-2xl font-bold text-gold">100 lichtjes</div>
                                <div class="text-slate-600 text-sm">Elk licht = &euro;10.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="hoe-het-werkt" class="py-16 md:py-20 px-4" aria-labelledby="hoe-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12 md:mb-16">
                <h2 id="hoe-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Hoe het werkt</h2>
                <p class="text-slate-600 text-lg md:text-xl max-w-2xl mx-auto">Vier stappen naar een schuldenvrije moskee</p>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="bg-white/80 rounded-2xl p-6 border border-slate-200 backdrop-blur-sm hover:border-gold/50 transition-colors group">
                    <div class="w-14 h-14 rounded-xl bg-gold/10 flex items-center justify-center mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-gold mb-2">Stap 1</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Vorm je team</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Verzamel familie, vrienden, collega's of buren en registreer je team op deze website. Kies een leuke teamnaam — alleen die is zichtbaar op het leaderboard. Alle donaties zijn anoniem.</p>
                </div>
                <div class="bg-white/80 rounded-2xl p-6 border border-slate-200 backdrop-blur-sm hover:border-gold/50 transition-colors group">
                    <div class="w-14 h-14 rounded-xl bg-gold/10 flex items-center justify-center mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-gold mb-2">Stap 2</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Stel je doel</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Kies een van de vier incentive-niveaus als teamdoel. Hoe hoger het doel, hoe groter de beloning voor het hele team.</p>
                </div>
                <div class="bg-white/80 rounded-2xl p-6 border border-slate-200 backdrop-blur-sm hover:border-gold/50 transition-colors group">
                    <div class="w-14 h-14 rounded-xl bg-gold/10 flex items-center justify-center mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-gold mb-2">Stap 3</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Deel je teamlink</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Deel je unieke teamlink via WhatsApp, social media of persoonlijk. Hoe breder je deelt, hoe sneller je het doel bereikt.</p>
                </div>
                <div class="bg-white/80 rounded-2xl p-6 border border-slate-200 backdrop-blur-sm hover:border-gold/50 transition-colors group">
                    <div class="w-14 h-14 rounded-xl bg-gold/10 flex items-center justify-center mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-gold mb-2">Stap 4</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Doneer, volg en vier</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Doneer zelf, volg de voortgang live op het leaderboard en zie de olijfboom oplichten. Vier elke mijlpaal met je team!</p>
                </div>
            </div>

            <div class="bg-amber-50/80 border border-gold/20 rounded-2xl p-6 md:p-8 max-w-3xl mx-auto text-center shadow-sm">
                <p class="text-slate-700 leading-relaxed text-base md:text-lg">
                    <strong class="text-gold">Nog geen team?</strong> Ontsteek een vonkje! Je hoeft niet meteen een team te vormen om bij te dragen. Doneer vanaf &euro;10 en ontsteek een vonkje voor de Olijfboom van Licht. Elke bijdrage telt, hoe klein ook. En wie weet sluit je later alsnog aan bij een team — of start je er zelf een.
                </p>
            </div>
        </div>
    </section>

    <section id="incentives" class="py-16 md:py-20 px-4 bg-slate-50/50" aria-labelledby="incentives-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12 md:mb-16">
                <h2 id="incentives-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Wat levert jouw inzet op?</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4 mb-6"></div>
                <p class="text-slate-700 text-lg mb-3 max-w-3xl mx-auto leading-relaxed">
                    ICB en haar sponsorpartners investeren maximaal 20% van het doelbedrag in incentives om teams te belonen. Zo wordt doneren een daad van sadaqah én een kans op iets bijzonders voor je team.
                </p>
                <p class="text-slate-600 max-w-2xl mx-auto text-sm md:text-base">
                    Bereik het bedrag en ontvang de beloning. Geen loterij — op volgorde van behalen.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer"
                    data-incentive-card
                    data-incentive-title="De Wortel"
                    data-incentive-amount="&euro;50.000 per team &bull; 5 beschikbaar"
                    data-incentive-description="Voor de teams die het verschil maken. Bereik met je team een donatiebedrag van &euro;50.000 en win een Fiat Topolino Verde Vita — de iconische Italiaanse stadsauto in een frisse, groene uitvoering. Compact, elektrisch en stijlvol: een symbool van vooruitgang, net als onze gemeenschap. Er zijn slechts vijf Topolino's beschikbaar. Eerste team, eerste keus."
                    data-incentive-image="{{ asset('images/hart-handen.png') }}"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-700 to-amber-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-gold">De Wortel</div>
                            <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">5 beschikbaar</div>
                        </div>
                        <div class="text-3xl font-bold text-slate-900 mb-4">&euro;50.000</div>
                        <div class="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                            <div class="text-lg font-bold text-slate-900">Fiat Topolino Verde Vita</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Iconische stadsauto — compact, elektrisch, groen</p>
                    </div>
                </div>
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer"
                    data-incentive-card
                    data-incentive-title="De Olijven"
                    data-incentive-amount="&euro;25.000 per team &bull; 5 beschikbaar"
                    data-incentive-description="Samen op reis, samen beloond. Bereik met je team &euro;25.000 en win een familievakantie naar Andalusië: inclusief vervoer, verblijf in een viersterrenhotel en een unieke islamitische culturele ervaring. Ontdek het rijke islamitische erfgoed van Al-Andalus met je gezin — van de Alhambra tot de Mezquita. Vijf vakanties beschikbaar voor de snelste teams."
                    data-incentive-image="{{ asset('images/olijf-tak.png') }}"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-600 to-amber-400"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-gold">De Olijven</div>
                            <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">5 beschikbaar</div>
                        </div>
                        <div class="text-3xl font-bold text-slate-900 mb-4">&euro;25.000</div>
                        <div class="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                            <div class="text-lg font-bold text-slate-900">Familievakantie Andalusië</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Al-Andalus met je gezin — Alhambra tot Mezquita</p>
                    </div>
                </div>
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer"
                    data-incentive-card
                    data-incentive-title="Het Grote Blad"
                    data-incentive-amount="&euro;10.000 per team &bull; 30 beschikbaar"
                    data-incentive-description="Een reis die je leven verandert. Bereik met je team &euro;10.000 en ga op Umrah met Al Amana, begeleid door imam Azzedine Karrat. Al Amana biedt deze Umrah-reis aan tegen kostprijs, als sponsorbijdrage aan de campagne. Een spirituele reis met je gemeenschap — dichter bij Allah swt. Meer informatie: almaqam.nl. Dertig plaatsen beschikbaar."
                    data-incentive-image="{{ asset('images/medina-moskee.png') }}"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-700 to-green-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-gold">Het Grote Blad</div>
                            <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">30 beschikbaar</div>
                        </div>
                        <div class="text-3xl font-bold text-slate-900 mb-4">&euro;10.000</div>
                        <div class="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                            <div class="text-lg font-bold text-slate-900">Umrah met Al Amana</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Herfstvakantie, begeleid door imam Azzedine Karrat</p>
                    </div>
                </div>
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer"
                    data-incentive-card
                    data-incentive-title="Het Kleine Blad"
                    data-incentive-amount="&euro;5.000 per team &bull; 40 beschikbaar"
                    data-incentive-description="Klein team, groot plezier. Bereik met je team &euro;5.000 en ontvang een gezinsuitje naar de Islam Experience museum in combinatie met een complete family dinner ter waarde van &euro;250. Een leerzame en inspirerende dag voor het hele gezin, afgesloten met een heerlijk diner samen. Meer informatie: islamexperience.nl. Veertig gezinsuitjes beschikbaar."
                    data-incentive-image="{{ asset('images/tasbih-gebed.png') }}"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-600 to-green-400"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-gold">Het Kleine Blad</div>
                            <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">40 beschikbaar</div>
                        </div>
                        <div class="text-3xl font-bold text-slate-900 mb-4">&euro;5.000</div>
                        <div class="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                            <div class="text-lg font-bold text-slate-900">Islam Experience + family dinner</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Leerzame dag + diner ter waarde van &euro;250</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <div class="bg-amber-50/80 border border-gold/20 rounded-2xl p-5 md:p-6 max-w-3xl mx-auto shadow-sm">
                    <p class="text-slate-700 text-sm md:text-base">
                        <strong class="text-gold">Let op:</strong> Bereik je het doel, dan ontvang je de beloning. Geen loterij — incentives worden toegekend op volgorde van behalen.
                    </p>
                </div>
            </div>
        </div>

        {{-- Incentive modal --}}
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 hidden"
            data-incentive-modal
            role="dialog"
            aria-modal="true"
        >
            <div class="bg-white rounded-2xl max-w-2xl w-full overflow-hidden shadow-2xl">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                    <h3 class="text-2xl font-bold text-slate-900" data-incentive-modal-title></h3>
                    <button
                        type="button"
                        class="text-slate-500 hover:text-slate-800 text-2xl leading-none"
                        data-incentive-modal-close
                        aria-label="Sluiten"
                    >&times;</button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="overflow-hidden rounded-xl border border-slate-200">
                        <img
                            src=""
                            alt=""
                            class="w-full h-56 md:h-64 object-cover"
                            data-incentive-modal-image
                        >
                    </div>
                    <p class="text-gold text-lg font-semibold" data-incentive-modal-amount></p>
                    <p class="text-slate-700 leading-relaxed" data-incentive-modal-description></p>
                </div>
            </div>
        </div>
    </section>

    <section id="teams" class="py-16 md:py-20 px-4 bg-slate-100/50" aria-labelledby="teams-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-10 md:mb-12">
                <div class="w-12 h-12 rounded-xl bg-gold/10 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h2 id="teams-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Samen sterker</h2>
                <p class="text-slate-600 text-lg mb-2">Zo werkt teamvorming</p>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4 mb-6"></div>
                <p class="text-slate-600 mb-6 max-w-2xl mx-auto leading-relaxed text-sm md:text-base">
                    Je bouwt mee met je team aan een gezamenlijk doel (min. 2, max. 50 leden). De teamcaptain registreert het team, kiest het incentive-niveau en deelt de teamlink. Op het leaderboard zie je alle teams; donaties zijn volledig anoniem.
                </p>
                <a href="{{ route('teams.create') }}" class="btn btn-primary">Vorm je team</a>
            </div>

            @if ($teams->isEmpty())
                <div class="text-center text-slate-600">
                    <p>Teams worden hier weergegeven zodra ze zijn aangemaakt.</p>
                    <p class="mt-2">Vorm een team om te beginnen!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" data-teams-container data-initial-count="6">
                    @foreach ($teams as $team)
                        @php
                            $percentage = round($team['progressRatio']);
                        @endphp
                        <a href="{{ route('teams.show', ['team' => $team['id']]) }}" data-team-card class="bg-white/80 rounded-2xl p-6 border border-slate-200 backdrop-blur-sm cursor-pointer hover:border-gold transition-colors">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-xl font-bold text-gold">{{ $team['name'] }}</h3>
                                <div class="w-6 h-6 rounded-full {{ $team['lampStatus'] ? 'bg-gold' : 'bg-slate-400' }} flex items-center justify-center">
                                    @if ($team['lampStatus'])
                                        <svg class="w-4 h-4 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 10 2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Opgehaald</span>
                                    <span class="text-gold font-semibold">&euro;{{ number_format($team['teamTotal'], 0, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-gold to-gold-dark h-2 rounded-full transition-all duration-500" style="width: {{ min($percentage, 100) }}%"></div>
                                </div>
                                <div class="text-xs text-slate-500 mt-1">
                                    Doel: &euro;{{ number_format($team['targetAmount'], 0, ',', '.') }} ({{ $percentage }}%)
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="text-center">
                    <button type="button" data-teams-load-more class="btn btn-secondary {{ $teams->count() > 6 ? '' : 'hidden' }}">
                        Bekijk meer teams
                    </button>
                </div>
            @endif
        </div>
    </section>

    <section id="deel-je-actie" class="py-16 md:py-20 px-4" aria-labelledby="deel-actie-heading">
        <div class="container mx-auto max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 items-center">
                <div class="md:col-span-2">
                    <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-lg">
                        <img src="{{ asset('images/hart-handen.png') }}" alt="Fundraising actie" class="w-full h-56 object-cover">
                    </div>
                </div>
                <div class="md:col-span-3">
                    <div class="w-12 h-12 rounded-xl bg-gold/10 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h2 id="deel-actie-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3 title-gradient">Deel je actie</h2>
                    <p class="text-slate-600 text-lg mb-3">Stuur je foto&rsquo;s in!</p>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Organiseer je eigen fundraising-actie — sponsorloop, koekenbakactie, garage sale, charity-iftar of welk idee je ook hebt. Stuur je mooiste foto&rsquo;s en een korte beschrijving naar <a href="mailto:info@icbarendrecht.nl" class="text-gold font-semibold hover:underline">info@icbarendrecht.nl</a> (onderwerp: Olijfboom van Licht — [naam actie]). Wij plaatsen de leukste acties op de website en social media.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="sponsoring" class="py-16 md:py-20 px-4 bg-slate-100/50" aria-labelledby="sponsoring-heading">
        <div class="container mx-auto max-w-4xl">
            <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white border border-slate-200 flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="text-center md:text-left">
                    <h2 id="sponsoring-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Sponsoring door bedrijven</h2>
                    <p class="text-slate-600 text-lg mb-3">Word sponsor van de Olijfboom van Licht</p>
                    <p class="text-slate-600 leading-relaxed">
                        Onderneemt u of vertegenwoordigt u een bedrijf? ICB biedt sponsormogelijkheden: financiële sponsoring, in-kind bijdragen, een bedrijfsteam of matching van medewerkersdonaties. Neem contact op via <a href="mailto:info@icbarendrecht.nl" class="text-gold font-semibold hover:underline">info@icbarendrecht.nl</a> (onderwerp: Sponsoring Olijfboom van Licht).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="dua" class="py-16 md:py-20 px-4 bg-slate-50/80" aria-labelledby="dua-heading">
        <div class="container mx-auto max-w-4xl">
            <div class="bg-white rounded-2xl p-6 md:p-10 border border-slate-200/80 shadow-sm flex flex-col md:flex-row gap-6 md:gap-8 items-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gold/10 flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <div class="text-center md:text-left">
                    <h2 id="dua-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Doe een dua-verzoek</h2>
                    <p class="text-slate-600 text-lg mb-3">Jouw dua, onze gemeenschap — samen bidden wij voor jou</p>
                    <p class="text-slate-600 leading-relaxed">
                        Wij bieden elke donateur de mogelijkheid om een dua-verzoek in te dienen. Onze imam en gemeenschap bidden voor jou en je dierbaren, in het bijzonder tijdens de gezegende nachten van Ramadan. Vertrouwelijk. Via het formulier hieronder of <a href="mailto:info@icbarendrecht.nl" class="text-gold font-semibold hover:underline">info@icbarendrecht.nl</a>.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="doneer" class="py-16 md:py-20 px-4 bg-slate-100/50" aria-labelledby="doneer-heading">
        <div class="container mx-auto max-w-2xl">
            <div class="text-center mb-10">
                <h2 id="doneer-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Doneer</h2>
                <p class="text-slate-600 text-lg">Kies een team en help ons het doel te bereiken</p>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>

            <div class="bg-white rounded-2xl md:rounded-3xl p-6 md:p-10 border border-slate-200/80 shadow-sm">
                @if (session('donation_success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 mb-6">
                        {{ session('donation_success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('donations.store') }}" data-donation-form>
                    @csrf
                    <div class="mb-8">
                        <label class="block text-slate-700 mb-4 font-medium">Stap 1: Kies je team *</label>
                        <select name="team_id" required data-donation-team class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none">
                            <option value="">-- Selecteer een team --</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team['id'] }}">{{ $team['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="block text-slate-700 mb-4 font-medium">Stap 2: Voer bedrag in *</label>

                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-4">
                            @foreach ([10, 25, 50, 100, 250] as $amount)
                                <button type="button" data-donation-suggested="{{ $amount }}" class="py-3 px-4 rounded-lg font-semibold transition-colors bg-white border border-slate-300 text-slate-700 hover:border-gold">
                                    &euro;{{ $amount }}
                                </button>
                            @endforeach
                        </div>

                        <div>
                            <label class="block text-slate-700 mb-2 font-medium">Of kies een ander bedrag</label>
                            <input type="number" name="amount" min="1" step="0.01" data-donation-amount class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none" placeholder="&euro;0,00" required>
                        </div>
                    </div>

                    <div data-donation-summary class="mb-8 p-4 bg-gold/10 border border-gold/30 rounded-lg hidden">
                        <div class="text-slate-700 mb-2">
                            <strong class="text-gold">Bedrag:</strong> <span data-donation-summary-amount>&nbsp;</span>
                        </div>
                        <div class="text-slate-700">
                            <strong class="text-gold">Team:</strong> <span data-donation-summary-team>&nbsp;</span>
                        </div>
                    </div>

                    <div class="mb-6 border-t border-slate-200 pt-6">
                        <h3 class="text-lg font-semibold mb-3 text-slate-800">Optioneel: verzoek om du&#257;</h3>
                        <div class="space-y-3">
                            <label class="inline-flex items-center gap-2 text-slate-700">
                                <input
                                    type="checkbox"
                                    name="dua_request_enabled"
                                    value="1"
                                    class="rounded border-slate-300 text-gold focus:ring-gold"
                                >
                                <span>Ik wil een du&#257;-verzoek toevoegen aan de nieuwsstrook</span>
                            </label>
                            <textarea
                                name="dua_request_text"
                                rows="2"
                                maxlength="255"
                                class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                                placeholder="Bijvoorbeeld: Maak du&#257; voor mijn familie, gezondheid, studie..."
                            >{{ old('dua_request_text') }}</textarea>
                            <p class="text-xs text-slate-500">
                                De du&#257; kan (na controle) kort zichtbaar worden in de nieuws-slider bovenaan de pagina.
                            </p>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-secondary w-full text-lg mb-4 bg-gold text-slate-900 border border-gold hover:bg-gold-dark"
                    >
                        Doneer via iDEAL (Mollie)
                    </button>

                    <p class="text-center text-sm text-slate-600">
                        Veilig betalen &bull; Direct bevestigd
                    </p>
                </form>
            </div>
        </div>
    </section>

    <section id="ons-verhaal" class="py-16 md:py-20 px-4 bg-slate-50/50" aria-labelledby="verhaal-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-10 md:mb-12">
                <h2 id="verhaal-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Ons verhaal</h2>
                <p class="text-slate-600 text-lg">Van droom naar werkelijkheid</p>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>

            @php
                $milestones = [
                    ['year' => 'Jarenlang', 'title' => 'Een gedeelde droom', 'text' => 'De wens voor een eigen gebeds- en ontmoetingsplek in Barendrecht. In aanloop naar Ramadan 2025 nam de gemeenschap gezamenlijk het initiatief.', 'img' => asset('images/kaaba.png')],
                    ['year' => 'Ramadan 2025', 'title' => 'Historische benefiet', 'text' => 'In vier dagen &euro;1.500.000 gedoneerd. Het pand aan het Bijdorpplein kon worden veiliggesteld; stichting ICB werd opgericht.', 'img' => asset('images/dadels-ramadan.png')],
                    ['year' => 'Dec 2025', 'title' => 'Pand overgenomen', 'text' => 'Volledige overname voor &euro;2.300.000 met renteloze leningen. &euro;250.000 overdrachtsbelasting bespaard. Rechtbank en bezwaarcommissie stelden ICB in het gelijk.', 'img' => asset('images/tasbih-gebed.png')],
                    ['year' => 'Nu', 'title' => 'Olijfboom van Licht', 'text' => 'De laatste stap: &euro;1.000.000 ophalen om de leningen terug te betalen. Een schuldenvrij centrum, gedragen door en voor Barendrecht.', 'img' => asset('images/olijf-tak.png')],
                ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($milestones as $m)
                    <div class="bg-white/90 rounded-2xl border border-slate-200 overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        <img src="{{ $m['img'] }}" alt="" class="w-full h-44 object-cover">
                        <div class="p-5">
                            <span class="text-xs font-bold text-gold uppercase tracking-wide">{{ $m['year'] }}</span>
                            <h3 class="text-xl font-bold text-slate-800 mt-1">{{ $m['title'] }}</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mt-2">{{ $m['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="faq" class="py-16 md:py-20 px-4 bg-slate-100/50" aria-labelledby="faq-heading">
        <div class="container mx-auto max-w-3xl">
            <div class="text-center mb-10 md:mb-12">
                <h2 id="faq-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Veelgestelde Vragen</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>

            <div class="space-y-4">
                @php
                    $faqs = [
                        ['question' => 'Wat is de Olijfboom van Licht?', 'answer' => 'De Olijfboom van Licht is de fondsenwervingscampagne van het Islamitisch Centrum Barendrecht tijdens Ramadan 2026. Het doel is om &euro;1.000.000 op te halen om de renteloze leningen aan gemeenschapsleden volledig terug te betalen.'],
                        ['question' => 'Waarom is dit geld nodig?', 'answer' => 'Het pand van ICB aan het Bijdorpplein 41 is volledig overgenomen voor &euro;2.300.000. Een deel hiervan is gefinancierd door donaties tijdens de benefiet in Ramadan 2025. Het resterende bedrag is gefinancierd met renteloze leningen van gemeenschapsleden. Het terugbetalen van deze leningen is een amanah die ICB zeer serieus neemt.'],
                        ['question' => 'Wat betekent elk lichtje op de olijfboom?', 'answer' => 'Elk brandend lichtje vertegenwoordigt &euro;10.000 aan donaties. De boom heeft 100 lichtjes. Wanneer alle lichtjes branden, is het doelbedrag van &euro;1.000.000 bereikt.'],
                        ['question' => 'Hoe werken de teams?', 'answer' => 'Je kunt een team vormen met familie, vrienden, collega\'s of andere gemeenschapsleden. Elk team kiest een incentive-niveau (&euro;5.000, &euro;10.000, &euro;25.000 of &euro;50.000) en werkt samen om dat doel te bereiken. Alle donaties via de teamlink tellen mee.'],
                        ['question' => 'Kan ik ook doneren zonder een team?', 'answer' => 'Ja, individuele donaties zijn welkom. Je kunt ook aansluiten bij een bestaand team. Elke bijdrage telt; je kunt al vanaf &euro;10 een vonkje ontsteken.'],
                        ['question' => 'Zijn donaties echt anoniem?', 'answer' => 'Ja, volledig. Niemand ziet wie wat doneert. Op het leaderboard verschijnt alleen de teamnaam en het totaalbedrag.'],
                        ['question' => 'Hoe lang loopt de campagne?', 'answer' => 'De campagne loopt tot en met het einde van Ramadan 2026. Teams vormen en doneren kan zodra de campagnewebsite live is.'],
                        ['question' => 'Kan ik een dua-verzoek indienen?', 'answer' => 'Ja. Elke donateur kan een dua-verzoek indienen. Onze imam en gemeenschap bidden voor jou en je dierbaren, in het bijzonder tijdens de gezegende nachten van Ramadan. Gebruik het formulier op de website of mail naar info@icbarendrecht.nl.'],
                        ['question' => 'Hoe kan mijn bedrijf ICB sponsoren?', 'answer' => 'Neem contact op via info@icbarendrecht.nl. Samen bekijken we welke mogelijkheden passen — van financiële bijdragen tot in-kind sponsoring of het vormen van een bedrijfsteam.'],
                    ];
                @endphp

                @foreach ($faqs as $index => $faq)
                    <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden hover:shadow-md transition-shadow" data-faq-item>
                        <button type="button" data-faq-button class="w-full px-5 md:px-6 py-4 text-left flex justify-between items-center hover:bg-slate-50/80 transition-colors gap-4">
                            <span class="font-semibold text-slate-800">{{ $faq['question'] }}</span>
                            <span class="text-gold text-xl ml-4" data-faq-icon>{{ $index === 0 ? '-' : '+' }}</span>
                        </button>
                        <div class="px-5 md:px-6 pb-4 pt-0 text-slate-600 leading-relaxed text-sm md:text-base {{ $index === 0 ? '' : 'hidden' }}" data-faq-body>
                            {!! $faq['answer'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="kernwaarden" class="py-16 md:py-20 px-4" aria-labelledby="kernwaarden-heading">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-10 md:mb-12">
                <h2 id="kernwaarden-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Onze kernwaarden</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-sm text-center hover:shadow-md hover:border-gold/30 transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-gold/10 flex items-center justify-center mx-auto mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gold mb-3">Uitmuntendheid</h3>
                    <p class="text-slate-600 leading-relaxed">We streven naar het hoogste in alles wat we doen — van gebedsdiensten tot organisatie en campagnes.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-sm text-center hover:shadow-md hover:border-gold/30 transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-gold/10 flex items-center justify-center mx-auto mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gold mb-3">Verbondenheid</h3>
                    <p class="text-slate-600 leading-relaxed">ICB is gebouwd op verbinding — tussen generaties, culturen en buren. Samen zijn we sterker.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-sm text-center hover:shadow-md hover:border-gold/30 transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-gold/10 flex items-center justify-center mx-auto mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gold mb-3">Toonaangevend</h3>
                    <p class="text-slate-600 leading-relaxed">Een voorbeeld voor onze kinderen, andere gemeenschappen en Barendrecht — professioneel, open en vooruitstrevend.</p>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
</div>
@endsection
