@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')
    <div class="pt-32 pb-20 px-4">
        <div class="container mx-auto max-w-2xl">
            <div class="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
                <h1 class="text-4xl font-bold mb-8 title-gradient text-center">Start een Team</h1>

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
                    <div>
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

                    <div>
                        <label class="block text-slate-700 mb-2 font-medium">Beschrijving (optioneel)</label>
                        <textarea
                            name="team_description"
                            class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                            rows="3"
                            placeholder="Korte beschrijving van je team..."
                        >{{ old('team_description') }}</textarea>
                    </div>

                    <div>
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

                    <div class="border-t border-slate-300 pt-6 mt-6">
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

                    <button type="submit" class="btn btn-primary w-full text-lg">
                        Team aanmaken
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
