@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')

    @if (session('status'))
        <div class="container mx-auto max-w-4xl px-4 pt-24 md:pt-28 pb-2">
            <p class="rounded-xl bg-green-100 text-green-800 border border-green-200 px-4 py-3 text-sm md:text-base text-center">
                {{ session('status') }}
            </p>
        </div>
    @endif

    <section class="pt-28 pb-16 md:pt-32 md:pb-20 px-4 {{ session('status') ? 'pt-8' : '' }}" aria-label="Hero">
        <div class="container mx-auto max-w-4xl flex flex-col items-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-5 title-gradient text-center max-w-4xl leading-tight">
                Nour ala Nour: Draag bij aan het Licht voor Moskee Barendrecht
            </h1>
            <p class="text-lg md:text-xl text-slate-700 mb-5 max-w-3xl text-center leading-relaxed">
                Zij gaven ons hun vertrouwen. Nu betalen wij het terug. Samen maken we het Islamitisch Centrum Barendrecht schuldenvrij — voor onze kinderen en de generaties na ons.
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
                    
                </div>
            </div>

            @if ($teams->count() > 0)
                <p class="text-slate-600 text-sm md:text-base text-center mb-10">
                    Al {{ $teams->count() }} teams geregistreerd — doe mee!
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
                                <span class="home-news-ticker__dua-label">Du&#257;-verzoek{{ is_array($dua) && !empty($dua['anonymous']) ? ' (anoniem)' : '' }}</span>
                                {{ is_array($dua) ? $dua['text'] : $dua }}
                            </span>
                        @endforeach
                    @endisset
                    {{-- Duplicate for seamless loop --}}
                    <span class="home-news-ticker__base" aria-hidden="true">{{ $tickerText }}</span>
                    @isset($duaTickerItems)
                        @foreach ($duaTickerItems as $dua)
                            <span class="home-news-ticker__dua" aria-hidden="true">
                                <span class="home-news-ticker__dua-label">Du&#257;-verzoek{{ is_array($dua) && !empty($dua['anonymous']) ? ' (anoniem)' : '' }}</span>
                                {{ is_array($dua) ? $dua['text'] : $dua }}
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

            {{-- Rij 1: Tekst | Afbeelding --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-stretch min-h-0 mb-6 md:mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-md p-6 md:p-8 flex flex-col justify-center order-2 md:order-1 min-w-0">
                    <h3 class="text-xs font-bold text-gold uppercase tracking-wide mb-3">De ayah</h3>
                    <blockquote class="border-l-4 border-gold pl-4 md:pl-5 py-1 bg-slate-50 rounded-r-lg">
                        <p class="text-slate-700 leading-relaxed italic text-sm md:text-base">
                            &ldquo;Allah is het licht van de hemelen en de aarde. De gelijkenis van Zijn licht (in het hart van de gelovige) is zoals een nis waarin licht is. Het licht bevindt zich in glas, het (licht in dit) glas is zoals dat van een parelachtige ster die werd aangestoken (met olie) van een gezegende olijfboom, noch uit het oosten, noch uit het westen. Zijn olie lijkt uit zichzelf te willen ontvlammen, hoewel geen vuur het heeft aangeraakt. Licht boven licht! Allah leidt naar Zijn licht wie Hij wil.&rdquo;
                        </p>
                        <cite class="text-sm text-slate-500 not-italic mt-2 block">Surah An-Nur, aya 35.</cite>
                    </blockquote>
                    <p class="text-slate-700 leading-relaxed mt-4 text-sm md:text-base mb-4">
                        Wij halen onze inspiratie uit deze aya en noemen deze campagne Nour ala Nour, niet omdat wij het licht zijn, maar omdat wij als gemeenschap, samen de dragers zijn van iets wat groter is dan onszelf. Elke bijdrage voegt een licht toe. Elke donatie brengt het volledig verlichten van de boom dichterbij.
                    </p>
                    <h3 class="text-xs font-bold text-gold uppercase tracking-wide mb-2 mt-4">Ons verhaal</h3>
                    <p class="text-slate-700 leading-relaxed text-sm md:text-base mb-0">
                        Wat begon als een droom, werd werkelijkheid door de kracht van onze gemeenschap. In Ramadan 2025 nam de Barendrechtse moslimgemeenschap het initiatief voor een eigen islamitisch centrum. Wat volgde was buitengewoon: in slechts vier dagen doneerde de gemeenschap &euro;1.500.000 tijdens een historische benefiet. Dankzij de moed en het vertrouwen van enkele gemeenschapsleden die renteloze leningen verstrekten, kon het pand aan het Bijdorpplein in december 2025 volledig worden overgenomen. Vanwege deze vrijgevigheid en moed werd een extra kostenpost van &euro;250.000 aan overdrachtsbelasting voorkomen, omdat ICB binnen 6 maanden volledig eigenaar van het pand werd.
                    </p>
                </div>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-md aspect-[4/3] min-h-[220px] md:min-h-[280px] order-1 md:order-2 min-w-0 w-full">
                    <img src="{{ asset('images/hero-olijfboom-3.png') }}" alt="Olijfboom van Licht" class="w-full h-full object-cover max-w-full">
                </div>
            </div>

            {{-- Rij 2: Afbeelding | Tekst --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-stretch min-h-0">
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-md aspect-[4/3] min-h-[220px] md:min-h-[280px] order-1 min-w-0 w-full">
                    <img src="{{ asset('images/hero-olijfboom-1.png') }}" alt="Gemeenschap Barendrecht" class="w-full h-full object-cover max-w-full">
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-md p-6 md:p-8 flex flex-col justify-center order-2 min-w-0">
                    <h3 class="text-xs font-bold text-gold uppercase tracking-wide mb-3">De campagne</h3>
                    <p class="text-slate-700 leading-relaxed text-sm md:text-base mb-6">
                        Nu is het moment om deze amanah aan deze helden in te lossen. Tijdens Ramadan 2026 lanceren wij de campagne Olijfboom van Licht: samen halen we &euro;1.000.000 op om de renteloze leningen volledig terug te betalen aan de mensen die ICB medemogelijk hebben gemaakt.
                    </p>
                    <div class="bg-amber-50/70 rounded-xl p-5">
                        <h3 class="text-xs font-bold text-gold uppercase tracking-wide mb-2">Sadaqah jariyah</h3>
                        <p class="text-slate-700 leading-relaxed text-sm md:text-base mb-0">
                            Onze olijfboom heeft 100 lichtjes. Elk lichtje vertegenwoordigt &euro;10.000. Wanneer alle lichtjes branden, is Moskee Barendrecht volledig schuldenvrij en in handen van de gemeenschap — voor nu en voor de generaties na ons. Dit is meer dan een donatie. Dit is sadaqah jariyah: een doorlopende liefdadigheid. Bij elk gebed dat in deze moskee wordt verricht, bij elke les die wordt gegeven, bij elk kind dat hier opgroeit in zijn geloof, ontvang jij als donateur ajar (beloning) van Allah swt. Tot de Dag des Oordeels. Dat is de werkelijke waarde van jouw bijdrage.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Campagnedoel --}}
            <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-md p-6 md:p-8 flex flex-wrap items-center justify-center gap-8 md:gap-12">
                <div class="text-center">
                    <p class="text-2xl md:text-3xl font-bold text-gold">&euro;1.000.000</p>
                    <p class="text-slate-600 text-sm mt-0.5">Campagnedoel</p>
                </div>
                <div class="text-slate-300 hidden md:block">|</div>
                <div class="text-center">
                    <p class="text-xl md:text-2xl font-bold text-gold">100 lichtjes</p>
                    <p class="text-slate-600 text-sm mt-0.5">Elk licht = &euro;10.000</p>
                </div>
            </div>
        </div>
    </section>

    <section id="hoe-het-werkt" class="py-16 md:py-20 px-4" aria-labelledby="hoe-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-8 md:mb-10">
                <h2 id="hoe-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Hoe het werkt</h2>
                <p class="text-slate-600 text-lg md:text-xl max-w-2xl mx-auto">Vier stappen naar een schuldenvrije moskee</p>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>
            <div class="rounded-2xl overflow-hidden border border-slate-200/80 shadow-md mb-10 max-w-4xl mx-auto h-32 md:h-40">
                <img src="{{ asset('images/olijf-tak.png') }}" alt="" class="w-full h-full object-cover object-center" role="presentation">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-12">
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg hover:border-gold/40 transition-all duration-200 group">
                    <div class="w-14 h-14 rounded-xl bg-gold/10 flex items-center justify-center mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-gold mb-2">Stap 1</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Vorm je team</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Verzamel familie, vrienden, collega&#39;s of buren en registreer je team op deze website. Kies een leuke teamnaam — die is zichtbaar op het leaderboard; donaties blijven anoniem. Elk team krijgt een eigen pagina met donatieteller.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg hover:border-gold/40 transition-all duration-200 group">
                    <div class="w-14 h-14 rounded-xl bg-gold/10 flex items-center justify-center mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-gold mb-2">Stap 2</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Stel je doel</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Kies een van de vier incentive-niveaus als teamdoel. Hoe hoger het doel, hoe groter de beloning voor het hele team.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg hover:border-gold/40 transition-all duration-200 group">
                    <div class="w-14 h-14 rounded-xl bg-gold/10 flex items-center justify-center mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-gold mb-2">Stap 3</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Deel je teamlink</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">Deel je unieke teamlink via WhatsApp, social media of persoonlijk. Vertel je teamnaam zodat mensen jullie team kunnen vinden en steunen. Hoe breder je deelt, hoe sneller het doel.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg hover:border-gold/40 transition-all duration-200 group">
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
                De incentives worden volledig mogelijk gemaakt door onze sponsorpartners. Zij stellen deze bijzondere beloningen beschikbaar als waardering voor de inzet en betrokkenheid van de teams. Doneren blijft in de kern een daad van sadaqah.
                </p>
                <p class="text-slate-600 max-w-2xl mx-auto text-sm md:text-base">
                    Bereik het bedrag en ontvang de beloning. Geen loterij — op volgorde van behalen.
                </p>
            </div>

            {{-- Eerste rij: €50.000 en €25.000 — Tweede rij: €10.000 en €5.000 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer h-full flex flex-col min-h-0"
                    data-incentive-card
                    data-incentive-title="De Wortel"
                    data-incentive-amount="&euro;50.000 per team &bull; 5 beschikbaar"
                    data-incentive-description="Voor de teams die het verschil maken.

Bereik met je team een donatiebedrag van €50.000 en win een Fiat Topolino Verde Vita,
— de iconische Italiaanse stadsauto in een frisse, groene uitvoering. Compact, elektrisch en
stijlvol: een symbool van vooruitgang, net als onze gemeenschap. Er zijn slechts vijf
Topolino&#39;s beschikbaar. Eerste team, eerste keus."
                    data-incentive-image="{{ asset('images/fiat-topolino.png') }}"
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
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer h-full flex flex-col min-h-0"
                    data-incentive-card
                    data-incentive-title="De Olijven"
                    data-incentive-amount="&euro;25.000 per team &bull; 5 beschikbaar"
                    data-incentive-description="Samen op reis, samen beloond. Bereik met je team &euro;25.000 en win een familievakantie naar Andalusië: inclusief vervoer, verblijf in een viersterrenhotel en een unieke islamitische culturele ervaring. Ontdek het rijke islamitische erfgoed van Al-Andalus met je gezin — van de Alhambra tot de Mezquita. Vijf vakanties beschikbaar voor de snelste teams."
                    data-incentive-image="{{ asset('images/alhambra-andalusie.png') }}"
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
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer h-full flex flex-col min-h-0"
                    data-incentive-card
                    data-incentive-title="Het Grote Blad"
                    data-incentive-amount="&euro;10.000 per team &bull; 30 beschikbaar"
                    data-incentive-description="Een reis die je leven verandert.
Bereik met je team €10.000 en ga op Umrah met Al Amana in de herfstvakantie, begeleid
door imam Azzedine Karrat. Al Amana biedt deze Umrah-reis aan tegen kostprijs, als
sponsorbijdrage aan de campagne. Een spirituele reis met je gemeenschap en— dichter bij
Allah swt. Meer informatie over Al Amana: almaqam.nl. Dertig plaatsen beschikbaar."
                    data-incentive-image="{{ asset('images/mecca-umrah.png') }}"
                    data-incentive-image-position="left top"
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
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer h-full flex flex-col min-h-0"
                    data-incentive-card
                    data-incentive-title="Het Kleine Blad"
                    data-incentive-amount="&euro;5.000 per team &bull; 40 beschikbaar"
                    data-incentive-description="Klein team, groot plezier. Bereik met je team &euro;5.000 en ontvang een compleet verzorgd gezinsuitje naar de Islam Experience in combinatie met een familie dinner. Een leerzame en inspirerende dag voor het hele gezin, afgesloten met een heerlijk diner samen. Meer informatie: islamexperience.nl. Veertig gezinsuitjes beschikbaar."
                    data-incentive-image="{{ asset('images/islam-experience.png') }}"
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
                            <div class="text-lg font-bold text-slate-900">Islam Experience + Familie dinner</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Leerzame dag + Heerlijk familie diner</p>
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
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 mb-10 max-w-6xl mx-auto items-stretch">
                <div class="lg:col-span-4 rounded-2xl overflow-hidden border border-slate-200/80 shadow-lg bg-white shrink-0">
                    <img src="{{ asset('images/hero-olijfboom-2.png') }}" alt="Samen sterker — teamvorming" class="w-full h-48 md:h-64 lg:h-full min-h-[200px] object-cover">
                </div>
                <div class="lg:col-span-8 bg-white rounded-2xl p-6 md:p-10 border border-slate-200/80 shadow-lg border-t-4 border-t-gold space-y-0">
                <p class="text-slate-700 leading-relaxed text-sm md:text-base mb-6 pb-6 border-b border-slate-200">
                    De kracht van de Olijfboom van Licht zit in samenwerking. Je doneert niet alleen, je bouwt mee — samen met je team.
                </p>
                <div class="py-6 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 mb-2 flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-gold/20 text-gold text-xs flex items-center justify-center font-bold">1</span> Wat is een team?</h3>
                    <p class="text-slate-700 leading-relaxed text-sm md:text-base ml-8">
                        Een groep donateurs (familie, vrienden, buren, collega&rsquo;s, sportmaatjes of moskeegangers) die samen een donatiedoel nastreeft. Minimaal 1, maximaal 50 leden.
                    </p>
                </div>
                <div class="py-6 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 mb-2 flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-gold/20 text-gold text-xs flex items-center justify-center font-bold">2</span> Wie is de teamcaptain?</h3>
                    <p class="text-slate-700 leading-relaxed text-sm md:text-base ml-8">
                        Registreert het team, kiest het incentive-niveau en deelt de teamlink. Houdt het team gemotiveerd en is de ambassadeur van het team.
                    </p>
                </div>
                <div class="py-6 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 mb-2 flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-gold/20 text-gold text-xs flex items-center justify-center font-bold">3</span> Hoe registreer je een team?</h3>
                    <p class="text-slate-700 leading-relaxed text-sm md:text-base ml-8">
                        Klik op &quot;Vorm je team&quot;, vul teamnaam en incentive-niveau in en ontvang je unieke link. Deel de link — alle donaties via jouw link tellen mee.
                    </p>
                </div>
                <div class="py-6 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 mb-2 flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-gold/20 text-gold text-xs flex items-center justify-center font-bold">4</span> Het leaderboard &amp; anonimiteit</h3>
                    <p class="text-slate-700 leading-relaxed text-sm md:text-base ml-8 mb-2">
                        Live leaderboard met alle teams en voortgang. Alle donaties zijn volledig anoniem — niemand ziet wie wat doneert. Alleen teamnaam en totaalbedrag zijn zichtbaar. Zo kun je geven vanuit oprechte intentie.
                    </p>
                    <p class="text-slate-700 leading-relaxed text-sm ml-8 italic">
                        Als teamcaptain kies je een pakkende teamnaam (bijv. &quot;De Barendrechtse Bouwers&quot;, &quot;Team Noor&quot;) en deelt die met je netwerk zodat mensen jullie team kunnen vinden.
                    </p>
                </div>
                <div class="py-6 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 mb-3 flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-gold/20 text-gold text-xs flex items-center justify-center font-bold">5</span> Tips voor teamcaptains</h3>
                    <ul class="ml-8 space-y-2 text-slate-700 text-sm md:text-base list-disc list-outside pl-4">
                        <li>Kies een pakkende, makkelijk te onthouden teamnaam</li>
                        <li>Stel een WhatsApp-groep in voor je team</li>
                        <li>Deel de teamlink actief op social media en via berichten</li>
                        <li>Geef het goede voorbeeld met je eigen donatie</li>
                        <li>Vier tussentijdse mijlpalen en daag andere teams uit</li>
                    </ul>
                </div>
                <!-- <div class="pt-6 bg-gold/10 border border-gold/30 rounded-xl p-4 mt-6">
                    <h3 class="text-base font-bold text-slate-800 mb-2">Referral-bonus: nodig 3 vrienden uit!</h3>
                    <p class="text-slate-700 leading-relaxed text-sm md:text-base mb-0">
                        Nodig minimaal 3 vrienden uit om via jouw teamlink te doneren en ontvang een persoonlijk dua-certificaat van de imam. Kost niets, waarde onbetaalbaar.
                    </p>
                </div> -->
                </div>
            </div>
            <div class="text-center mb-10">
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
                        <a href="{{ route('teams.show', ['team' => $team['id']]) }}" data-team-card class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-md cursor-pointer hover:shadow-lg hover:border-gold/50 transition-all duration-200">
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

    <section id="deel-je-actie" class="py-16 md:py-20 px-4 bg-white" aria-labelledby="deel-actie-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="bg-slate-50/80 rounded-3xl overflow-hidden border border-slate-200/80 shadow-xl flex flex-col md:flex-row">
                <div class="md:w-2/5 flex-shrink-0">
                    <div class="relative aspect-[4/3] md:aspect-auto md:h-full min-h-[240px]">
                        <img src="{{ asset('images/hart-handen.png') }}" alt="Fundraising actie" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent md:bg-gradient-to-r md:from-transparent md:via-transparent md:to-slate-50/80"></div>
                    </div>
                </div>
                <div class="md:w-3/5 p-6 md:p-10 flex flex-col justify-center border-t-4 border-t-gold md:border-t-0 md:border-l-4 md:border-l-gold">
                    <div class="w-12 h-12 rounded-xl bg-gold/10 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h2 id="deel-actie-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3 title-gradient">Deel je actie — stuur je foto&rsquo;s in!</h2>
                    <p class="text-slate-600 text-lg mb-4">Organiseer je eigen fundraising-actie en deel het met de gemeenschap.</p>
                    <p class="text-slate-600 leading-relaxed mb-4 text-sm md:text-base">
                        Naast directe giften moedigen we creatieve acties aan: sponsorloop, koekenbakactie, garage sale, charity-iftar, wasstraat-actie met de jeugd — alles is welkom. Via het formulier kun je veilig je foto&rsquo;s en beschrijving insturen; wij plaatsen de leukste acties op de site en social media.
                    </p>
                    <div class="bg-slate-50 rounded-xl p-4 mb-4 border border-slate-200">
                        <h3 class="text-sm font-bold text-slate-800 mb-3">Wat stuur je in?</h3>
                        <ul class="space-y-2 text-slate-600 text-sm md:text-base list-disc list-outside pl-4">
                            <li>Foto&rsquo;s van je actie (hoge kwaliteit, liefst liggend)</li>
                            <li>Korte beschrijving: wat, wie deed mee, hoeveel opgehaald?</li>
                            <li>Je teamnaam (als je bij een team bent)</li>
                            <li>Toestemming voor plaatsing op website en social media</li>
                        </ul>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center px-4 py-2 rounded-lg bg-gold text-slate-900 font-semibold text-sm md:text-base border border-gold hover:bg-gold-dark transition-colors"
                        data-open-modal="actie-fotos"
                    >
                        Stuur je actie &amp; foto&#39;s in
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section id="sponsoring" class="py-16 md:py-20 px-4 bg-slate-100/50" aria-labelledby="sponsoring-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="flex flex-col lg:flex-row gap-0 rounded-3xl overflow-hidden border border-slate-200/80 shadow-xl bg-white">
                <div class="lg:w-2/5 relative min-h-[220px] lg:min-h-0">
                    <img src="{{ asset('images/medina-moskee.png') }}" alt="Sponsoring Olijfboom van Licht" class="w-full h-full min-h-[220px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent lg:bg-gradient-to-r lg:from-transparent lg:to-white/90"></div>
                </div>
                <div class="lg:w-3/5 p-6 md:p-10 flex flex-col justify-center border-t-4 border-t-gold lg:border-t-0 lg:border-l-4 lg:border-l-gold">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gold/10 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div class="text-center lg:text-left">
                    <h2 id="sponsoring-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Sponsoring door bedrijven</h2>
                    <p class="text-slate-600 text-lg mb-4">Word sponsor van de Olijfboom van Licht</p>
                    <p class="text-slate-600 leading-relaxed mb-4 text-sm md:text-base">
                        Bent u ondernemer of vertegenwoordigt u een bedrijf? ICB biedt sponsormogelijkheden voor bedrijven die willen bijdragen aan een sterke, verbonden gemeenschap.
                    </p>
                    <div class="mb-4">
                        <h3 class="text-sm font-bold text-slate-800 mb-2">Mogelijkheden</h3>
                        <ul class="text-slate-600 text-sm md:text-base space-y-1 list-disc list-outside pl-4">
                            <li>Financiële sponsoring van (een) incentive(s)</li>
                            <li>In-kind: producten, diensten, locaties</li>
                            <li>Bedrijfsteam dat samen doneert</li>
                            <li>Matchen van donaties van medewerkers</li>
                        </ul>
                    </div>
                    <p class="text-slate-600 leading-relaxed text-sm md:text-base mb-4">
                        Sponsoring verbindt uw merk aan een positief, landelijk zichtbaar initiatief.
                    </p>
                    <button
                        type="button"
                        class="inline-flex items-center px-4 py-2 rounded-lg bg-gold text-slate-900 font-semibold text-sm md:text-base border border-gold hover:bg-gold-dark transition-colors"
                        data-open-modal="sponsoring"
                    >
                        Word sponsor
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="dua" class="py-16 md:py-20 px-4 bg-slate-50/80" aria-labelledby="dua-heading">
        <div class="container mx-auto max-w-6xl">
            <div class="rounded-3xl overflow-hidden border border-slate-200/80 shadow-xl bg-white flex flex-col lg:flex-row">
                <div class="lg:w-2/5 relative min-h-[200px] lg:min-h-0">
                    <img src="{{ asset('images/tasbih-gebed.png') }}" alt="Dua — samen bidden" class="w-full h-full min-h-[200px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent lg:bg-gradient-to-r lg:from-transparent lg:to-white/90"></div>
                </div>
                <div class="lg:w-3/5 p-6 md:p-10 flex flex-col justify-center border-t-4 border-t-gold lg:border-t-0 lg:border-l-4 lg:border-l-gold">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gold/10 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <div>
                    <h2 id="dua-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Doe een dua-verzoek</h2>
                    <p class="text-slate-600 text-lg mb-4">Jouw dua, onze gemeenschap — samen bidden wij voor jou</p>
                        </div>
                    </div>
                    <p class="text-slate-600 leading-relaxed mb-4 text-sm md:text-base">
                        Elke donateur kan een dua-verzoek indienen. Onze imam en gemeenschap bidden voor jou en je dierbaren — vooral tijdens de gezegende nachten van Ramadan. Vertrouwelijk; je deelt alleen wat je wilt.
                    </p>
                    <p class="text-slate-600 leading-relaxed mb-4 text-sm md:text-base">
                        <strong>Hoe?</strong> Via het formulier op deze pagina of mail naar <a href="mailto:info@icbarendrecht.nl" class="text-gold font-semibold hover:underline">info@icbarendrecht.nl</a>.
                    </p>
                    <blockquote class="text-slate-600 text-sm italic border-l-4 border-gold/50 pl-4 py-2 bg-slate-50/80 rounded-r-lg">
                        De Profeet &#65018; zei: &quot;De dua van een moslim voor zijn broeder in diens afwezigheid wordt verhoord. Bij zijn hoofd staat een engel die zegt: Ameen, en voor jou hetzelfde.&quot; (Sahih Muslim)
                    </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="doneer" class="py-16 md:py-20 px-4 bg-slate-100/50" aria-labelledby="doneer-heading">
        <div class="container mx-auto max-w-2xl">
            <div class="rounded-2xl overflow-hidden border border-slate-200/80 shadow-md mb-8 h-28 md:h-36">
                <img src="{{ asset('images/dua-handen.png') }}" alt="" class="w-full h-full object-cover object-center" role="presentation">
            </div>
            <div class="text-center mb-10">
                <h2 id="doneer-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Doneer</h2>
                <p class="text-slate-600 text-lg">Kies een team of doneer zonder team</p>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>

            <div class="bg-white rounded-2xl md:rounded-3xl p-6 md:p-10 border border-slate-200/80 shadow-lg border-t-4 border-t-gold ring-1 ring-slate-200/50">
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
                    {{-- Stap 1: team of zonder team --}}
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                Stap 1
                            </span>
                            <span class="text-xs text-slate-500">Verplicht</span>
                        </div>
                        <label class="block text-slate-700 mb-2 font-medium">Kies je team of doneer zonder team</label>
                        <select
                            name="team_id"
                            data-donation-team
                            class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                        >
                            <option value="">— Doneer zonder team —</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team['id'] }}" {{ old('team_id') == $team['id'] ? 'selected' : '' }}>
                                    {{ $team['name'] }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-slate-500">
                            Laat de selectie leeg als je wilt doneren zonder team. Je kunt dan kiezen om anoniem te blijven of je naam achter te laten.
                        </p>
                    </div>

                    {{-- Donatie zonder team: anoniem of met naam --}}
                    <div data-donation-no-team class="mb-8 p-4 bg-slate-50 border border-slate-200 rounded-xl hidden">
                        <div class="flex items-start gap-3">
                            <div class="mt-1">
                                <div class="w-8 h-8 rounded-xl bg-gold/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-slate-800 font-semibold mb-1">Donatie zonder team</p>
                                <p class="text-xs text-slate-500 mb-3">
                                    Kies of je volledig anoniem wilt doneren, of dat je je naam wilt invullen zodat we weten van wie de donatie komt.
                                </p>
                                <label class="inline-flex items-center gap-2 text-slate-700 mb-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="donation_anonymous"
                                        value="1"
                                        data-donation-anonymous
                                        class="rounded border-slate-300 text-gold focus:ring-gold"
                                        {{ old('donation_anonymous') ? 'checked' : '' }}
                                    >
                                    <span>Anoniem doneren</span>
                                </label>
                                <div data-donation-name-row class="mt-2">
                                    <label class="block text-slate-700 mb-2 font-medium">
                                        Jouw naam
                                        <span class="text-slate-500 font-normal">(verplicht als je niet anoniem doneert)</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="donor_name"
                                        value="{{ old('donor_name') }}"
                                        maxlength="255"
                                        data-donation-name
                                        class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                                        placeholder="Bijv. Mohammed"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Stap 2: bedrag --}}
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                Stap 2
                            </span>
                            <span class="text-xs text-slate-500">Verplicht</span>
                        </div>
                        <label class="block text-slate-700 mb-3 font-medium">Voer bedrag in *</label>

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
                            <strong class="text-gold">Team / naam:</strong> <span data-donation-summary-team>&nbsp;</span>
                        </div>
                    </div>

                    {{-- Stap 3: optioneel dua-verzoek --}}
                    <div class="mb-6 border-t border-slate-200 pt-6">
                        <div class="flex items-center justify-between mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                Stap 3
                            </span>
                            <span class="text-xs text-slate-500">Optioneel</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-slate-800">Verzoek om du&#257;</h3>
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
                            <label class="inline-flex items-center gap-2 text-slate-700">
                                <input
                                    type="checkbox"
                                    name="dua_request_anonymous"
                                    value="1"
                                    class="rounded border-slate-300 text-gold focus:ring-gold"
                                >
                                <span>Anoniem du&#257;-verzoek</span>
                            </label>
                            <p class="text-xs text-slate-500">
                                De du&#257; kan (na controle) kort zichtbaar worden in de nieuws-slider bovenaan de pagina. Bij anoniem wordt je naam niet getoond.
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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-6xl mx-auto items-start">
                <div class="lg:col-span-4 rounded-2xl overflow-hidden border border-slate-200/80 shadow-lg lg:sticky lg:top-24">
                    <img src="{{ asset('images/medina-moskee.png') }}" alt="Ons verhaal — van droom naar werkelijkheid" class="w-full h-48 object-cover">
                    <div class="p-4 bg-slate-50 border-t border-slate-200">
                        <p class="text-slate-600 text-sm font-medium">Van droom naar werkelijkheid</p>
                    </div>
                </div>
                <div class="lg:col-span-8 bg-white rounded-2xl p-6 md:p-10 border border-slate-200/80 shadow-lg border-t-4 border-t-gold">
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <span class="flex-shrink-0 text-xs font-bold text-gold uppercase tracking-wide w-24 pt-0.5">Jarenlang</span>
                        <p class="text-slate-700 leading-relaxed text-sm md:text-base flex-1">
                            Binnen de Barendrechtse islamitische gemeenschap leeft al tientallen jaren de wens voor een eigen gebeds- en ontmoetingsplek. In aanloop naar Ramadan 2025 namen Barendrechters gezamenlijk het initiatief; vanuit saamhorigheid en spiritualiteit ontstond een beweging die niemand had verwacht.
                        </p>
                    </div>
                    <div class="flex gap-4 border-t border-slate-100 pt-6">
                        <span class="flex-shrink-0 text-xs font-bold text-gold uppercase tracking-wide w-24 pt-0.5">Ramadan 2025</span>
                        <p class="text-slate-700 leading-relaxed text-sm md:text-base flex-1">
                            Een hechte, etnisch overstijgende gemeenschap groeide. Divers talent en vrijwilligers gaven alles; met de hulp van Allah swt ontstond een unieke kans: een pand aan het Bijdorpplein kon worden veiliggesteld. De stichting ICB werd opgericht. In vier dagen doneerde de gemeenschap &euro;1.500.000 — het pand werd voor tweederde aanbetaald.
                        </p>
                    </div>
                    <div class="flex gap-4 border-t border-slate-100 pt-6">
                        <span class="flex-shrink-0 text-xs font-bold text-gold uppercase tracking-wide w-24 pt-0.5">Dec 2025</span>
                        <p class="text-slate-700 leading-relaxed text-sm md:text-base flex-1">
                            Het pand werd volledig overgenomen voor &euro;2.300.000, gefinancierd met renteloze leningen vanuit de gemeenschap. &euro;250.000 overdrachtsbelasting bespaard. Het pand staat nu op naam van ICB. Er was weerstand vanuit de gemeente, maar rechtbank en bezwaarcommissie stelden ICB in het gelijk — de gemeenschap werd er sterker en hechter door.
                        </p>
                    </div>
                    <div class="flex gap-4 border-t border-slate-100 pt-6">
                        <span class="flex-shrink-0 text-xs font-bold text-gold uppercase tracking-wide w-24 pt-0.5">Nu</span>
                        <p class="text-slate-700 leading-relaxed text-sm md:text-base flex-1">
                            De laatste stap: de renteloze leningen terugbetalen aan de gemeenschapsleden die ICB mogelijk maakten. Met de campagne Olijfboom van Licht sluiten we dit hoofdstuk af en openen we dat van een volledig schuldenvrij islamitisch centrum, gedragen door en voor Barendrecht.
                        </p>
                    </div>
                </div>
                </div>
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
                        ['question' => 'Wat is de Olijfboom van Licht?', 'answer' => 'De Olijfboom van Licht is de fondsenwervingscampagne van het Islamitisch Centrum Barendrecht tijdens Ramadan 2026. Het doel is om €1.000.000 op te halen om de renteloze leningen aan gemeenschapsleden volledig terug te betalen.'],
                        ['question' => 'Waarom is dit geld nodig?', 'answer' => 'Het pand van ICB aan het Bijdorpplein 41 is volledig overgenomen voor €2.300.000. Een deel hiervan (€1.500.000) is gefinancierd door donaties tijdens het benefiet in Ramadan 2025. Het resterende bedrag is gefinancierd met renteloze leningen van gemeenschapsleden. Het terugbetalen van deze leningen is een amanah (vertrouwensplicht) die ICB zeer serieus neemt.'],
                        ['question' => 'Wat betekent elk lichtje op de olijfboom?', 'answer' => 'Elk brandend lichtje op de digitale olijfboom vertegenwoordigt €10.000 aan donaties. De boom heeft 100 lichtjes. Wanneer alle lichtjes branden, is het doelbedrag van €1.000.000 bereikt.'],
                        ['question' => 'Hoe werken de teams?', 'answer' => 'Je kunt een team vormen met familie, vrienden, collega\'s of andere gemeenschapsleden. Elk team kiest een incentive-niveau (€5.000, €10.000, €25.000 of €50.000) en werkt samen om dat doel te bereiken. Alle donaties via de teamlink tellen mee.'],
                        ['question' => 'Hoe worden de incentives gefinancierd?', 'answer' => 'Dankzij onze partnernetwerk kunnen we teams extra motiveren. Incentives worden mogelijk gemaakt door sponsoren. Al Amana bijvoorbeeld levert Umrah-tickets tegen kostprijs aan. Belangrijk: dit is een stimulans voor teaminzet, geen doel op zichzelf.'],
                        ['question' => 'Kan ik ook doneren zonder een team?', 'answer' => 'Ja, individuele donaties zijn uiteraard welkom. Je kunt ook aansluiten bij een bestaand team. Wij moedigen teamvorming aan omdat het de betrokkenheid en het plezier vergroot, maar elke bijdrage telt.'],
                        ['question' => 'Wat is het minimale donatiebedrag?', 'answer' => 'Er is geen minimumbedrag — je kunt al vanaf €10 een vonkje ontsteken. Elke bijdrage, groot of klein, brengt ons dichter bij een schuldenvrije moskee. Je hoeft geen team te hebben om te doneren. De Profeet &#65018; zei: "De beste daad is die welke voortdurend wordt verricht, ook al is het weinig."'],
                        ['question' => 'Hoe weet ik dat mijn donatie goed terechtkomt?', 'answer' => 'ICB is een stichting met een transparant bestuur. Alle donaties worden uitsluitend gebruikt voor het terugbetalen van de renteloze leningen. Na afloop van de campagne publiceert ICB een volledig financieel overzicht.'],
                        ['question' => 'Is mijn donatie aftrekbaar?', 'answer' => 'ICB is in bezit van de ANBI-status. Donaties, — zijn dus fiscaal aftrekbaar.'],
                        ['question' => 'Kan ik een bedrijf of onderneming inschrijven als team?', 'answer' => 'Absoluut. Bedrijven en ondernemers zijn van harte welkom om een team te vormen. Dit is een mooie manier om maatschappelijke betrokkenheid te tonen en tegelijkertijd je team te versterken.'],
                        ['question' => 'Hoe lang loopt de campagne?', 'answer' => 'De campagnewebsite gaat live op maandag 23 februari 2026. Vanaf dat moment kun je teams vormen en doneren. De campagne loopt door tot en met het einde van Ramadan 2026 of tot wij ons doelbedrag hebben bereikt.'],
                        ['question' => 'Kan ik mijn donatie spreiden?', 'answer' => 'Ja, je kunt in meerdere termijnen doneren gedurende de campagne. Alle bedragen worden opgeteld bij je teamtotaal.'],
                        ['question' => 'Hoe worden de incentive-winnaars bepaald?', 'answer' => 'Elk team dat het gekozen doelbedrag bereikt, ontvangt de bijbehorende incentive. Het is geen loterij: bereik je het doel, dan ontvang je de beloning. Op is op — incentives worden toegekend op volgorde van behalen.'],
                        ['question' => 'Wat als niet alle lichtjes worden aangestoken?', 'answer' => 'Elk bedrag dat wordt opgehaald, wordt direct ingezet voor het terugbetalen van leningen. Ook als het volledige doelbedrag niet wordt bereikt, maakt elke donatie een verschil.'],
                        ['question' => 'Zijn donaties echt anoniem?', 'answer' => 'Ja, volledig. Niemand ziet wie wat doneert — niet de teamcaptain, niet andere teamleden, niet het bestuur van ICB. Op het leaderboard verschijnt alleen de teamnaam en het totaalbedrag. Zo kun je geven vanuit zuivere intentie, zonder dat iemand je donatiebedrag kent. Als teamcaptain kies je simpelweg een leuke teamnaam en deel je die met je netwerk, zodat mensen het team kunnen vinden en steunen.'],
                        ['question' => 'Kan ik een dua-verzoek indienen?', 'answer' => 'Absoluut. Elke donateur — en eigenlijk iedereen — kan een dua-verzoek indienen. Onze imam en gemeenschap bidden voor jou en je dierbaren, in het bijzonder tijdens de gezegende nachten van Ramadan. Gebruik het formulier op de website of mail naar info@icbarendrecht.nl.'],
                        ['question' => 'Hoe kan mijn bedrijf ICB sponsoren?', 'answer' => 'Bedrijven kunnen ICB sponsoren door contact op te nemen via info@icbarendrecht.nl. Samen bekijken we welke sponsormogelijkheden passen — van financiële bijdragen tot in-kind sponsoring of het vormen van een bedrijfsteam.'],
                        // ['question' => 'Wat is de Laylat al-Qadr Challenge?', 'answer' => 'Tijdens de laatste tien nachten van Ramadan — waarin Laylat al-Qadr valt — tellen donaties dubbel op het leaderboard (als bonus-score, niet financieel). Dit is de meest gezegende periode van het jaar, en wij willen teams extra motiveren om juist dan alles te geven.'],
                        ['question' => 'Wat gebeurt er na de campagne?', 'answer' => 'Na afloop van de campagne publiceert ICB een transparant financieel verslag. Alle donateurs ontvangen een persoonlijke bedanking en een uitnodiging voor de officiële opening van Moskee Barendrecht.'],
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
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-10 md:mb-12">
                <h2 id="kernwaarden-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Onze kernwaarden</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-lg text-center hover:shadow-xl hover:border-gold/40 transition-all duration-200 group border-t-4 border-t-gold/30">
                    <div class="w-16 h-16 rounded-2xl bg-gold/10 flex items-center justify-center mx-auto mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gold mb-3">Uitmuntendheid</h3>
                    <p class="text-slate-600 leading-relaxed">We streven naar het hoogste in alles wat we doen — van onze gebedsdiensten tot onze organisatie, van onze campagnes tot onze gemeenschapsactiviteiten.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-lg text-center hover:shadow-xl hover:border-gold/40 transition-all duration-200 group border-t-4 border-t-gold/30">
                    <div class="w-16 h-16 rounded-2xl bg-gold/10 flex items-center justify-center mx-auto mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gold mb-3">Verbondenheid</h3>
                    <p class="text-slate-600 leading-relaxed">ICB is gebouwd op de kracht van verbinding. Verbinding tussen generaties, tussen culturen, tussen buren. Samen zijn we sterker.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/80 shadow-lg text-center hover:shadow-xl hover:border-gold/40 transition-all duration-200 group border-t-4 border-t-gold/30">
                    <div class="w-16 h-16 rounded-2xl bg-gold/10 flex items-center justify-center mx-auto mb-4 group-hover:bg-gold/20 transition-colors">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gold mb-3">Toonaangevend</h3>
                    <p class="text-slate-600 leading-relaxed">We willen een voorbeeld zijn — voor onze kinderen, voor andere gemeenschappen, voor heel Barendrecht. Een professioneel, open en vooruitstrevend islamitisch centrum.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Modals voor sponsoring en actie-foto's --}}
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4 py-6 hidden"
        data-modal="sponsoring"
        aria-hidden="true"
    >
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900">Sponsoring door bedrijven</h2>
                <button type="button" class="text-slate-500 hover:text-slate-800 text-2xl leading-none" data-modal-close aria-label="Sluiten">&times;</button>
            </div>
            <form method="POST" action="{{ route('contact.sponsoring') }}" class="px-6 py-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="sponsoring_name">Naam</label>
                    <input type="text" id="sponsoring_name" name="name" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="sponsoring_email">E-mailadres</label>
                    <input type="email" id="sponsoring_email" name="email" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="sponsoring_phone">Telefoonnummer</label>
                    <input type="tel" id="sponsoring_phone" name="phone" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="sponsoring_message">Korte toelichting (optioneel)</label>
                    <textarea id="sponsoring_message" name="message" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" placeholder="Bijv. type sponsoring, bedrijf, bereikbaarheid..."></textarea>
                </div>
                <div class="flex items-center justify-between pt-2 pb-4">
                    <button type="button" class="text-sm text-slate-500 hover:text-slate-700" data-modal-close>Annuleren</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-gold text-slate-900 font-semibold text-sm border border-gold hover:bg-gold-dark transition-colors">
                        Verstuur verzoek
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4 py-6 hidden"
        data-modal="actie-fotos"
        aria-hidden="true"
    >
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900">Stuur je actie &amp; foto&#39;s in</h2>
                <button type="button" class="text-slate-500 hover:text-slate-800 text-2xl leading-none" data-modal-close aria-label="Sluiten">&times;</button>
            </div>
            <form method="POST" action="{{ route('contact.action-photos') }}" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="actie_name">Naam</label>
                    <input type="text" id="actie_name" name="name" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="actie_email">E-mailadres</label>
                    <input type="email" id="actie_email" name="email" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="actie_phone">Telefoonnummer</label>
                    <input type="tel" id="actie_phone" name="phone" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="actie_team">Naam team / actie</label>
                    <input type="text" id="actie_team" name="team_name" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="actie_photos">Foto&#39;s uploaden (max. 10)</label>
                    <input
                        type="file"
                        id="actie_photos"
                        name="photos[]"
                        accept="image/*"
                        multiple
                        class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-gold hover:file:bg-gold/20"
                    >
                    <p class="mt-1 text-xs text-slate-500">Upload bij voorkeur liggende foto&#39;s. Maximaal 10 bestanden.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="actie_message">Korte beschrijving (optioneel)</label>
                    <textarea id="actie_message" name="message" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:border-gold" placeholder="Bijv. wat was de actie, wie deden mee, hoeveel is opgehaald?"></textarea>
                </div>
                <div class="flex items-center justify-between pt-2 pb-4">
                    <button type="button" class="text-sm text-slate-500 hover:text-slate-700" data-modal-close>Annuleren</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-gold text-slate-900 font-semibold text-sm border border-gold hover:bg-gold-dark transition-colors">
                        Verstuur actie
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')
</div>
@endsection
