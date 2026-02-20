@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')

    <section class="pt-32 pb-20 px-4">
        <div class="container mx-auto max-w-4xl text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 title-gradient">
                Olijfboom van Licht
            </h1>
            <p class="text-xl md:text-2xl text-slate-700 mb-4">
                100 lichten voor &euro;1.000.000
            </p>
            <p class="text-lg text-slate-600 mb-12 max-w-2xl mx-auto">
                Steun het Islamitisch Centrum Barendrecht door een licht te ontsteken.
                Elk licht vertegenwoordigt &euro;10.000 en brengt ons dichter bij ons doel.
                Samen bouwen we aan een sterkere gemeenschap.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                <button type="button" data-scroll-doneer class="btn btn-secondary text-lg">
                    Doneer nu
                </button>
                <a href="{{ route('teams.create') }}" class="btn btn-primary text-lg">
                    Start een team
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <div class="bg-white/80 rounded-2xl p-6 backdrop-blur-sm border border-slate-200">
                    <div class="text-3xl font-bold text-gold mb-2">
                        &euro;{{ number_format($totalRaised, 0, ',', '.') }}
                    </div>
                    <div class="text-slate-600">Totaal opgehaald</div>
                </div>
                <div class="bg-white/80 rounded-2xl p-6 backdrop-blur-sm border border-slate-200">
                    <div class="text-3xl font-bold text-gold mb-2">
                        {{ $lightsActivated }}
                    </div>
                    <div class="text-slate-600">Lichten aan</div>
                </div>
                <div class="bg-white/80 rounded-2xl p-6 backdrop-blur-sm border border-slate-200">
                    <div class="text-3xl font-bold text-gold mb-2">
                        {{ round($progressPercentage) }}%
                    </div>
                    <div class="text-slate-600">Naar doel</div>
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

    <section id="doel" class="py-20 px-4 bg-slate-100/60">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 title-gradient">Ons Doel</h2>
                <p class="text-xl text-slate-700 max-w-2xl mx-auto">
                    Waarom we deze campagne hebben gestart
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/80 rounded-2xl p-8 border border-slate-200 hover:border-gold/50 transition-colors backdrop-blur-sm">
                    <h3 class="text-2xl font-bold mb-4 text-gold">Lening aflossen</h3>
                    <p class="text-slate-600 leading-relaxed">Verminder onze schuld zodat we meer kunnen investeren in de gemeenschap.</p>
                </div>
                <div class="bg-white/80 rounded-2xl p-8 border border-slate-200 hover:border-gold/50 transition-colors backdrop-blur-sm">
                    <h3 class="text-2xl font-bold mb-4 text-gold">Investeren in jongeren &amp; onderwijs</h3>
                    <p class="text-slate-600 leading-relaxed">Ondersteun educatieve programma's en activiteiten voor de jeugd.</p>
                </div>
                <div class="bg-white/80 rounded-2xl p-8 border border-slate-200 hover:border-gold/50 transition-colors backdrop-blur-sm">
                    <h3 class="text-2xl font-bold mb-4 text-gold">Sterke gemeenschap opbouwen</h3>
                    <p class="text-slate-600 leading-relaxed">Bouw samen aan een hechte en bloeiende moslimgemeenschap in Barendrecht.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="incentives" class="py-20 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 title-gradient">Boom van Licht - Incentives</h2>
                <p class="text-xl text-slate-700 mb-4">
                    Iedereen (individu, familie, bedrijf of team) krijgt de incentive zodra het bijbehorende bedrag is ingezameld
                </p>
                <p class="text-lg text-slate-600 max-w-3xl mx-auto">
                    Uitgangspunt: <span class="font-bold text-gold">1 licht = &euro;10.000</span>. Er is geen loterij en geen puntensysteem.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer"
                    data-incentive-card
                    data-incentive-title="Wortels"
                    data-incentive-amount="&euro;50.000 &bull; 5 lichten"
                    data-incentive-description="Diepe verbinding met de gemeenschap. Deze incentive vertegenwoordigt de stevige wortels van onze boom en ondersteunt langdurige projecten voor het centrum."
                    data-incentive-image="https://picsum.photos/seed/wortels-icb/960/540"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-700 to-amber-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-gold">Wortels</div>
                            <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">5 lichten</div>
                        </div>
                        <div class="text-3xl font-bold text-slate-900 mb-4">&euro;50.000</div>
                        <div class="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                            <div class="text-lg font-bold text-slate-900">Family Corendon all-inclusive vakantie</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Diepe verbinding met de gemeenschap</p>
                    </div>
                </div>
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer"
                    data-incentive-card
                    data-incentive-title="Olijven"
                    data-incentive-amount="&euro;25.000 &bull; 2,5 lichten"
                    data-incentive-description="Vruchtbare bijdrage aan het centrum. Met deze incentive help je om belangrijke programma’s en activiteiten structureel mogelijk te maken."
                    data-incentive-image="https://picsum.photos/seed/olijven-icb/960/540"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-600 to-amber-400"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-gold">Olijven</div>
                            <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">2,5 lichten</div>
                        </div>
                        <div class="text-3xl font-bold text-slate-900 mb-4">&euro;25.000</div>
                        <div class="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                            <div class="text-lg font-bold text-slate-900">ICB Umrah-ticket</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Vruchtbare bijdrage aan het centrum</p>
                    </div>
                </div>
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer"
                    data-incentive-card
                    data-incentive-title="Bladeren (groot)"
                    data-incentive-amount="&euro;10.000 &bull; 1 licht"
                    data-incentive-description="Elk groot blad staat voor een krachtige bijdrage. Deze incentive zorgt voor zichtbare impact op de Olijfboom van Licht."
                    data-incentive-image="https://picsum.photos/seed/bladeren-groot-icb/960/540"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-700 to-green-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-gold">Bladeren (groot)</div>
                            <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">1 licht</div>
                        </div>
                        <div class="text-3xl font-bold text-slate-900 mb-4">&euro;10.000</div>
                        <div class="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                            <div class="text-lg font-bold text-slate-900">Islamitische VIP-ervaring</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Elk blad draagt bij aan de boom</p>
                    </div>
                </div>
                <div
                    class="bg-white/90 rounded-2xl p-6 border-2 border-slate-200 hover:border-gold transition-all hover:shadow-xl backdrop-blur-sm relative overflow-hidden group cursor-pointer"
                    data-incentive-card
                    data-incentive-title="Bladeren (klein)"
                    data-incentive-amount="&euro;5.000 &bull; 0,5 licht"
                    data-incentive-description="Ook kleinere bijdragen zijn onmisbaar. Deze incentive laat zien dat elke donatie telt en zichtbaar wordt in de boom."
                    data-incentive-image="https://picsum.photos/seed/bladeren-klein-icb/960/540"
                >
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-600 to-green-400"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-gold">Bladeren (klein)</div>
                            <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">0,5 licht</div>
                        </div>
                        <div class="text-3xl font-bold text-slate-900 mb-4">&euro;5.000</div>
                        <div class="mb-3 p-3 bg-gradient-to-r from-gold/10 to-gold/5 rounded-lg border border-gold/20">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Beloning</div>
                            <div class="text-lg font-bold text-slate-900">Islamitische belevingen &amp; kenniservaringen</div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">Elk blad draagt bij aan de boom</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <div class="bg-gold/10 border border-gold/30 rounded-xl p-6 max-w-3xl mx-auto">
                    <p class="text-slate-700 text-lg">
                        <strong class="text-gold">Let op:</strong> De metafoor van de boom werkt met lichten. Elk niveau wordt bereikt zodra het team het bijbehorende bedrag heeft ingezameld.
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

    <section id="teams" class="py-20 px-4 bg-slate-100/60">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 title-gradient">Teams van Licht</h2>
                <p class="text-xl text-slate-700 mb-8">
                    Samen bereiken we meer. Start of sluit je aan bij een team
                </p>
                <a href="{{ route('teams.create') }}" class="btn btn-primary">Maak een team aan</a>
            </div>

            @if ($teams->isEmpty())
                <div class="text-center text-slate-600">
                    <p>Teams worden hier weergegeven zodra ze zijn aangemaakt.</p>
                    <p class="mt-2">Start een team om te beginnen!</p>
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

    <section id="doneer" class="py-20 px-4">
        <div class="container mx-auto max-w-2xl">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 title-gradient">Doneer</h2>
                <p class="text-xl text-slate-700">
                    Kies een groep en help ons het doel te bereiken
                </p>
            </div>

            <div class="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
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
                        <label class="block text-slate-700 mb-4 font-medium">Stap 1: Kies je groep *</label>
                        <select name="team_id" required data-donation-team class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none">
                            <option value="">-- Selecteer een groep --</option>
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
                            <strong class="text-gold">Groep:</strong> <span data-donation-summary-team>&nbsp;</span>
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

    <section id="faq" class="py-20 px-4 bg-slate-100/60">
        <div class="container mx-auto max-w-3xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 title-gradient">Veelgestelde Vragen</h2>
            </div>

            <div class="space-y-4">
                @php
                    $faqs = [
                        [
                            'question' => 'Waar gaat het geld naartoe?',
                            'answer' => 'Het opgehaalde geld wordt gebruikt om de lening van het centrum af te lossen, te investeren in educatieve programma\'s voor jongeren, en om de gemeenschap verder te versterken.',
                        ],
                        [
                            'question' => 'Kan ik als bedrijf doneren?',
                            'answer' => 'Ja, bedrijven zijn van harte welkom om te doneren. Neem contact met ons op voor meer informatie over zakelijke donaties en mogelijke voordelen.',
                        ],
                        [
                            'question' => 'Krijg ik een bevestiging?',
                            'answer' => 'Ja, na uw donatie ontvangt u automatisch een bevestigingsmail met de details van uw donatie. U kunt deze gebruiken voor uw administratie.',
                        ],
                        [
                            'question' => 'Kan ik een team starten?',
                            'answer' => 'Ja! U kunt een eigen team oprichten en anderen uitnodigen om samen donaties te verzamelen. Dit maakt het leuker en effectiever om het doel te bereiken.',
                        ],
                        [
                            'question' => 'Wat betekent 1 licht?',
                            'answer' => 'Elk licht vertegenwoordigt &euro;10.000. Wanneer we &euro;10.000 hebben opgehaald, wordt er een licht op de olijfboom geactiveerd. We hebben 100 lichten nodig om ons doel van &euro;1.000.000 te bereiken.',
                        ],
                    ];
                @endphp

                @foreach ($faqs as $index => $faq)
                    <div class="bg-white/80 rounded-xl border border-slate-200 backdrop-blur-sm overflow-hidden" data-faq-item>
                        <button type="button" data-faq-button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-white/80 transition-colors">
                            <span class="font-semibold text-slate-800">{{ $faq['question'] }}</span>
                            <span class="text-gold text-xl ml-4" data-faq-icon>{{ $index === 0 ? '-' : '+' }}</span>
                        </button>
                        <div class="px-6 pb-4 text-slate-600 leading-relaxed {{ $index === 0 ? '' : 'hidden' }}" data-faq-body>
                            {!! $faq['answer'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.footer')
</div>
@endsection
