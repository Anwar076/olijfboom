@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')

    <div class="pt-32 pb-20 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold title-gradient">Team Dashboard</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-600 hover:text-gold transition-colors">Uitloggen</button>
                </form>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                    {{ $errors->first() }}
                </div>
            @endif
            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg p-4 mb-6">
                    {{ session('status') }}
                </div>
            @endif

            @if (auth()->user()->isAdmin())
                <div class="bg-white/80 rounded-2xl p-6 mb-6 border border-slate-200 backdrop-blur-sm">
                    <h3 class="text-xl font-bold mb-4 title-gradient">Nieuwsticker op home</h3>
                    <form method="POST" action="{{ route('dashboard.home-news-ticker') }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-slate-700 mb-2 font-medium">Ticker tekst *</label>
                            <textarea
                                name="news_ticker_text"
                                rows="3"
                                maxlength="2000"
                                required
                                class="w-full bg-white border border-slate-300 rounded-lg px-4 py-2 text-slate-900 focus:border-gold focus:outline-none"
                            >{{ old('news_ticker_text', $homeNewsTickerText) }}</textarea>
                            <p class="text-xs text-slate-500 mt-2">Deze tekst loopt onder de navigatie op de homepagina.</p>
                        </div>
                        <button type="submit" class="btn btn-primary">Ticker opslaan</button>
                    </form>
                </div>

                <div class="bg-white/80 rounded-2xl p-6 mb-6 border border-slate-200 backdrop-blur-sm">
                    <h3 class="text-xl font-bold mb-4 title-gradient">Media rij beheren (afbeeldingen + video's)</h3>
                    @php
                        $editableUrls = old('media_urls');
                        if (!is_array($editableUrls)) {
                            $editableUrls = collect($dashboardShowcaseMedia)->pluck('url')->all();
                        }
                        $editableUrls = array_values(array_pad($editableUrls, 5, ''));
                    @endphp
                    <form method="POST" action="{{ route('dashboard.showcase-media') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        @foreach ($editableUrls as $mediaUrl)
                            <div>
                                <label class="block text-slate-700 mb-2 font-medium">Media URL (image of video)</label>
                                <input
                                    type="url"
                                    name="media_urls[]"
                                    value="{{ $mediaUrl }}"
                                    placeholder="https://..."
                                    class="w-full bg-white border border-slate-300 rounded-lg px-4 py-2 text-slate-900 focus:border-gold focus:outline-none"
                                >
                            </div>
                        @endforeach
                        <div>
                            <label class="block text-slate-700 mb-2 font-medium">Upload bestanden</label>
                            <input
                                type="file"
                                name="media_files[]"
                                accept="image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime"
                                multiple
                                class="w-full bg-white border border-slate-300 rounded-lg px-4 py-2 text-slate-900 focus:border-gold focus:outline-none"
                            >
                        </div>
                        <p class="text-xs text-slate-500">Ondersteunt: jpg, png, webp, gif, mp4, webm, mov. Max 12 items, 50MB per upload.</p>
                        <button type="submit" class="btn btn-primary">Media opslaan</button>
                    </form>
                </div>
            @endif

            @if (!$team)
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-6 text-center">
                    Team niet gevonden
                </div>
            @else
                @php
                    $percentage = round($progressRatio);
                    $goalReached = $lampStatus;
                @endphp
                <div class="bg-white/80 rounded-2xl p-6 mb-6 border border-slate-200 backdrop-blur-sm">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold mb-2 title-gradient">{{ $team->name }}</h2>
                            @if ($team->description)
                                <p class="text-slate-600">{{ $team->description }}</p>
                            @endif
                        </div>
                        <div class="w-8 h-8 rounded-full {{ $lampStatus ? 'bg-gold' : 'bg-slate-400' }} flex items-center justify-center">
                            @if ($lampStatus)
                                <svg class="w-5 h-5 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M11 3a1 1 0 10-2 0v1a1 1 0 10 2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <div class="text-sm text-slate-600">Teamdoel</div>
                            <div class="text-xl font-bold text-gold">{{ $team->target_label }}: &euro;{{ number_format($team->target_amount, 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-slate-600">Totaal opgehaald</div>
                            <div class="text-xl font-bold text-gold">&euro;{{ number_format($teamTotal, 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-slate-600">Leden</div>
                            <div class="text-xl font-bold text-gold">{{ $members->count() }}</div>
                        </div>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-gold to-gold-dark h-2 rounded-full transition-all duration-500" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                    <div class="text-xs text-slate-500 mt-2">{{ $percentage }}% naar doel</div>
                </div>

                @if (auth()->user()->isAdmin())
                    <div class="bg-white/80 rounded-2xl p-6 mb-6 border border-slate-200 backdrop-blur-sm">
                        <h3 class="text-xl font-bold mb-4 title-gradient">Volgend teamdoel kiezen</h3>
                        @unless ($goalReached)
                            <p class="text-sm text-slate-600 mb-4">
                                Bereik eerst je huidige teamdoel om een nieuw doel te kunnen kiezen.
                            </p>
                        @endunless
                        @php
                            $selectedTargetLabel = old('target_label', $team->target_label);
                            $selectedTargetAmount = (int) old('target_amount', (float) $team->target_amount);
                            $selectedValue = $selectedTargetLabel . '::' . $selectedTargetAmount;
                        @endphp
                        <form method="POST" action="{{ route('dashboard.team.goal') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            @csrf
                            @method('PUT')
                            <div class="md:col-span-2">
                                <label class="block text-slate-700 mb-2 font-medium">Nieuw teamdoel *</label>
                                <select
                                    required
                                    name="target_option"
                                    class="w-full bg-white border border-slate-300 rounded-lg px-4 py-2 text-slate-900 focus:border-gold focus:outline-none {{ $goalReached ? '' : 'opacity-60 cursor-not-allowed' }}"
                                    onchange="const [label, amount] = this.value.split('::'); this.form.target_label.value = label; this.form.target_amount.value = amount;"
                                    {{ $goalReached ? '' : 'disabled' }}
                                >
                                    @foreach ($targetOptions as $option)
                                        @php
                                            $value = $option['label'] . '::' . $option['amount'];
                                        @endphp
                                        <option value="{{ $value }}" {{ $selectedValue === $value ? 'selected' : '' }}>
                                            {{ $option['label'] }}: &euro;{{ number_format($option['amount'], 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="target_label" value="{{ $selectedTargetLabel }}">
                                <input type="hidden" name="target_amount" value="{{ $selectedTargetAmount }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-full {{ $goalReached ? '' : 'opacity-60 cursor-not-allowed' }}" {{ $goalReached ? '' : 'disabled' }}>
                                Bijwerken
                            </button>
                        </form>
                    </div>

                    <div class="bg-white/80 rounded-2xl p-6 mb-6 border border-slate-200 backdrop-blur-sm">
                        <h3 class="text-xl font-bold mb-4 title-gradient">Uitnodigingen</h3>
                        @if ($inviteUrl)
                            <div class="flex gap-4 items-center">
                                <input type="text" value="{{ $inviteUrl }}" readonly data-invite-input class="flex-1 bg-white border border-slate-300 rounded-lg px-4 py-2 text-slate-900 text-sm">
                                <button type="button" data-copy-invite class="btn btn-primary">Kopieer link</button>
                                <form method="POST" action="{{ route('dashboard.invites') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">Nieuw</button>
                                </form>
                            </div>
                        @else
                            <form method="POST" action="{{ route('dashboard.invites') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Genereer uitnodigingslink</button>
                            </form>
                        @endif
                    </div>

                    <div class="bg-white/80 rounded-2xl p-6 mb-6 border border-slate-200 backdrop-blur-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold title-gradient">Lid toevoegen</h3>
                        </div>
                        <form method="POST" action="{{ route('dashboard.members.add') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @csrf
                            <input type="text" name="name" placeholder="Naam" required class="bg-white border border-slate-300 rounded-lg px-4 py-2 text-slate-900 focus:border-gold focus:outline-none">
                            <input type="email" name="email" placeholder="Email" required class="bg-white border border-slate-300 rounded-lg px-4 py-2 text-slate-900 focus:border-gold focus:outline-none">
                            <button type="submit" class="btn btn-primary">Toevoegen</button>
                        </form>
                    </div>
                @endif

                <div class="bg-white/80 rounded-2xl p-6 border border-slate-200 backdrop-blur-sm">
                    <h3 class="text-xl font-bold mb-4 title-gradient">Teamleden</h3>
                    <div class="space-y-4">
                        @foreach ($members as $member)
                            <div class="bg-white/80 rounded-lg p-4 border border-slate-300 flex flex-col md:flex-row md:items-center gap-4">
                                <div class="flex-1">
                                    <div class="font-semibold text-slate-900">{{ $member->name }}</div>
                                    <div class="text-sm text-slate-600">{{ $member->email }}</div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ $member->role === 'admin' ? 'Beheerder' : 'Gebruiker' }}
                                    </div>
                                </div>
                                @if (auth()->user()->isAdmin() && $member->user_id !== auth()->id())
                                    <form method="POST" action="{{ route('dashboard.members.remove', ['member' => $member->id]) }}" onsubmit="return confirm('Weet je zeker dat je dit lid wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 transition-colors">
                                            Verwijderen
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
