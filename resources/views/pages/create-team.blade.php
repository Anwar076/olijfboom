@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')
    <div class="pt-28 pb-20 px-4">
        <div class="container mx-auto max-w-4xl">
            {{-- Tutorial: uitleg voor je een team aanmaakt --}}
            <div class="mb-12 md:mb-16">
                <div class="text-center mb-10">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2 title-gradient">Team aanmaken</h1>
                    <p class="text-slate-600 text-lg max-w-2xl mx-auto">Lees eerst hoe het werkt, dan vul je het formulier in</p>
                    <div class="w-16 h-1 bg-gradient-to-r from-transparent via-gold to-transparent rounded-full mx-auto mt-4"></div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-8">
                    <div class="p-6 md:p-8 border-b border-slate-200 bg-slate-50/50">
                        <h2 class="text-xl md:text-2xl font-bold text-slate-800 mb-2">Wat is een team?</h2>
                        <p class="text-slate-600 leading-relaxed">
                            Een team is een groep mensen (familie, vrienden, buren of collega’s) die samen een donatiedoel kiest en dat doel probeert te halen. Alleen de <strong>teamnaam</strong> is zichtbaar op het leaderboard; alle donaties blijven <strong>anoniem</strong>. Jij wordt de teambeheerder: je deelt de teamlink en kunt later leden toevoegen.
                        </p>
                    </div>
                    <div class="p-6 md:p-8">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Wat gebeurt er als je een team aanmaakt?</h2>
                        <ol class="space-y-4">
                            <li class="flex gap-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-gold/20 text-gold font-bold flex items-center justify-center text-sm">1</span>
                                <div>
                                    <strong class="text-slate-800">Je kiest een teamnaam en een doel</strong> — bijvoorbeeld &euro;5.000, &euro;10.000, &euro;25.000 of &euro;50.000. Bij dat doel hoort een incentive (beloning) voor het hele team als jullie het bedrag halen.
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-gold/20 text-gold font-bold flex items-center justify-center text-sm">2</span>
                                <div>
                                    <strong class="text-slate-800">Je krijgt een persoonlijk dashboard</strong> — daar kun je een uitnodigingslink maken en die link delen met iedereen die je wilt uitnodigen voor je team.
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-gold/20 text-gold font-bold flex items-center justify-center text-sm">3</span>
                                <div>
                                    <strong class="text-slate-800">Je deelt je teamlink</strong> — via WhatsApp, social media of in persoon. Mensen die via jouw link doneren, tellen mee voor jullie teamdoel. Niemand ziet wie wat heeft gedoneerd.
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-gold/20 text-gold font-bold flex items-center justify-center text-sm">4</span>
                                <div>
                                    <strong class="text-slate-800">Jullie halen het doel</strong> — wanneer jullie teamtotaal het gekozen bedrag bereikt, ontvangt het team de bijbehorende beloning (op volgorde van behalen). Geen loterij.
                                </div>
                            </li>
                        </ol>
                    </div>
                    <div class="p-6 md:p-8 bg-amber-50/50 border-t border-slate-200">
                        <h2 class="text-xl font-bold text-slate-800 mb-3">De vier doelniveaus</h2>
                        <p class="text-slate-600 text-sm mb-4">Kies één doel voor je team. Hoe hoger het doel, hoe groter de beloning als jullie het halen. Op de <a href="{{ route('home') }}#incentives" class="text-gold font-semibold hover:underline">homepagina bij Incentives</a> lees je per niveau wat jullie kunnen winnen.</p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-slate-700">
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gold"></span> <strong>&euro;5.000</strong> — Het Kleine Blad (o.a. Islam Experience + family dinner)</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gold"></span> <strong>&euro;10.000</strong> — Het Grote Blad (o.a. Umrah met Al Amana)</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gold"></span> <strong>&euro;25.000</strong> — De Olijven (o.a. familievakantie Andalusië)</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gold"></span> <strong>&euro;50.000</strong> — De Wortel (o.a. Fiat Topolino Verde Vita)</li>
                        </ul>
                    </div>
                    <div class="p-6 md:p-8 border-t border-slate-200">
                        <h2 class="text-xl font-bold text-slate-800 mb-3">Wat vul je hieronder in?</h2>
                        <ul class="space-y-2 text-slate-600 text-sm">
                            <li><strong class="text-slate-800">Teamnaam en beschrijving</strong> — Alleen de teamnaam is zichtbaar op de site; een korte beschrijving is optioneel.</li>
                            <li><strong class="text-slate-800">Teamdoel</strong> — Kies één van de vier niveaus (&euro;5.000 t/m &euro;50.000).</li>
                            <li><strong class="text-slate-800">Jouw gegevens (beheerder)</strong> — Naam, e-mail en wachtwoord. Hiermee log je in op het dashboard om je teamlink te maken en later leden toe te voegen. Je e-mail wordt niet publiek getoond.</li>
                        </ul>
                        <p class="mt-4 text-slate-600 text-sm">
                            Na het aanmaken word je direct ingelogd en kun je in je dashboard een uitnodigingslink genereren en deelnemers uitnodigen.
                        </p>
                    </div>
                </div>

                <div class="text-center mb-8 flex flex-col sm:flex-row gap-3 justify-center items-center">
                    <button type="button" data-tour-start data-tour="create-team" class="btn btn-secondary text-lg px-6 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Start interactieve rondleiding
                    </button>
                    <a href="#team-form" class="btn btn-primary text-lg px-8">Naar het formulier — team aanmaken</a>
                </div>
            </div>

            {{-- Formulier --}}
            <div id="team-form" class="scroll-mt-24">
                <div class="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 title-gradient text-center">Formulier: start je team</h2>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('teams.store') }}" class="space-y-6">
                    @csrf
                    @php
                        $selectedTargetLabel = old('target_label', $targetOptions[0]['label']);
                        $selectedTargetAmount = old('target_amount', $targetOptions[0]['amount']);
                        $selectedValue = $selectedTargetLabel . '::' . $selectedTargetAmount;
                    @endphp
                    <div data-tour-step="team-name">
                        <label class="block text-slate-700 mb-2 font-medium">Team naam *</label>
                        <input
                            type="text"
                            name="team_name"
                            required
                            value="{{ old('team_name') }}"
                            class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                            placeholder="Bijv. Team Vrijwilligers"
                        />
                    </div>

                    <div data-tour-step="team-description">
                        <label class="block text-slate-700 mb-2 font-medium">Beschrijving (optioneel)</label>
                        <textarea
                            name="team_description"
                            class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                            rows="3"
                            placeholder="Korte beschrijving van je team..."
                        >{{ old('team_description') }}</textarea>
                    </div>

                    <div data-tour-step="team-goal">
                        <label class="block text-slate-700 mb-2 font-medium">Kies teamdoel *</label>
                        <select
                            required
                            name="target_option"
                            class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                            onchange="const [label, amount] = this.value.split('::'); this.form.target_label.value = label; this.form.target_amount.value = amount;"
                        >
                            @foreach ($targetOptions as $option)
                                @php
                                    $value = $option['label'] . '::' . $option['amount'];
                                @endphp
                                <option value="{{ $value }}" {{ $selectedValue === $value ? 'selected' : '' }}>{{ $option['label'] }}: &euro;{{ number_format($option['amount'], 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="target_label" value="{{ $selectedTargetLabel }}">
                        <input type="hidden" name="target_amount" value="{{ $selectedTargetAmount }}">
                    </div>

                    <div class="border-t border-slate-300 pt-6 mt-6" data-tour-step="team-admin">
                        <h2 class="text-2xl font-bold mb-6 title-gradient">Beheerder Account</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-slate-700 mb-2 font-medium">Naam *</label>
                                <input
                                    type="text"
                                    name="name"
                                    required
                                    value="{{ old('name') }}"
                                    class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                                />
                            </div>

                            <div>
                                <label class="block text-slate-700 mb-2 font-medium">Email *</label>
                                <input
                                    type="email"
                                    name="email"
                                    required
                                    value="{{ old('email') }}"
                                    class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                                />
                            </div>

                            <div>
                                <label class="block text-slate-700 mb-2 font-medium">Wachtwoord *</label>
                                <input
                                    type="password"
                                    name="password"
                                    required
                                    minlength="6"
                                    class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                                />
                            </div>

                            <div>
                                <label class="block text-slate-700 mb-2 font-medium">Bevestig wachtwoord *</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    minlength="6"
                                    class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                                />
                            </div>
                        </div>
                    </div>

                    <div data-tour-step="team-submit">
                        <button type="submit" class="btn btn-primary w-full text-lg">
                            Team aanmaken
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
