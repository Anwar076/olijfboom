@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-50">
    @include('partials.header')

    <div class="pt-28 pb-20 px-4 md:pt-32">
        <div class="container mx-auto max-w-3xl">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-gold transition-colors mb-8 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Terug naar homepage
            </a>

            @php
                $percentage = round($progressRatio);
            @endphp

            {{-- Hoofdkaart --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-amber-600 via-gold to-amber-500"></div>
                <div class="p-8 md:p-10 lg:p-12">
                    {{-- Teamnaam + status --}}
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold title-gradient leading-tight">{{ $team->name }}</h1>
                        <div class="flex items-center gap-2 shrink-0">
                            @if ($lampStatus)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-gold/15 text-amber-800 border border-gold/30">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 10 2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z"/></svg>
                                    Doel bereikt
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full {{ $lampStatus ? 'bg-gold' : 'bg-slate-200' }}">
                                    @if ($lampStatus)
                                        <svg class="w-5 h-5 text-slate-900" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 10 2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z"/></svg>
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($team->description)
                        <p class="text-slate-600 text-lg leading-relaxed mb-8">{{ $team->description }}</p>
                    @endif

                    {{-- Voortgang --}}
                    <div class="bg-slate-50/80 rounded-2xl p-6 md:p-7 border border-slate-200/80 mb-8">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-slate-600 font-medium">Totaal opgehaald</span>
                            <span class="text-2xl md:text-3xl font-bold text-gold">&euro;{{ number_format($teamTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden mb-2">
                            <div class="h-3 rounded-full bg-gradient-to-r from-gold to-amber-600 transition-all duration-700 ease-out" style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                        <div class="flex justify-between text-sm text-slate-500">
                            <span>Doel: &euro;{{ number_format($team->target_amount, 0, ',', '.') }}</span>
                            <span class="font-semibold text-slate-700">{{ $percentage }}%</span>
                        </div>
                    </div>

                    {{-- Teamleden --}}
                    <div class="pt-6 border-t border-slate-200">
                        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-gold/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            Teamleden
                        </h2>
                        @if (count($members) === 0)
                            <p class="text-slate-500 text-sm">Nog geen teamleden zichtbaar.</p>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($members as $member)
                                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 border border-slate-200/80 px-4 py-3 hover:border-gold/30 hover:bg-amber-50/30 transition-colors">
                                        <span class="w-8 h-8 rounded-full bg-gold/15 flex items-center justify-center text-gold shrink-0">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                        </span>
                                        <span class="text-slate-800 font-medium truncate">{{ $member }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Acties --}}
                    <div class="mt-10 pt-8 border-t border-slate-200">
                        <input type="hidden" data-team-link-url value="{{ url()->route('teams.show', $team) }}">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-stretch sm:items-center">
                            <a href="{{ route('home', ['team' => $team->id]) }}#doneer" class="btn btn-primary text-lg min-h-[52px] px-8">
                                Doneer aan dit team
                            </a>
                            <button type="button" data-copy-team-link class="btn btn-secondary min-h-[52px] px-6 inline-flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                Deel dit team
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
