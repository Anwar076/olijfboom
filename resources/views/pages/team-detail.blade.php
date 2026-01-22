@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')

    <div class="pt-32 pb-20 px-4">
        <div class="container mx-auto max-w-4xl">
            <a href="{{ route('home') }}" class="text-slate-600 hover:text-gold transition-colors mb-8 inline-block">
                &larr; Terug naar homepage
            </a>

            @php
                $percentage = round($progressRatio);
            @endphp

            <div class="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
                <div class="flex items-start justify-between mb-4">
                    <h1 class="text-4xl md:text-5xl font-bold title-gradient">{{ $team->name }}</h1>
                    <div class="w-8 h-8 rounded-full {{ $lampStatus ? 'bg-gold' : 'bg-slate-400' }} flex items-center justify-center">
                        @if ($lampStatus)
                            <svg class="w-5 h-5 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 10 2 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.477.859h4z" />
                            </svg>
                        @endif
                    </div>
                </div>

                @if ($team->description)
                    <p class="text-slate-700 mb-8 text-lg">{{ $team->description }}</p>
                @endif

                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-slate-600">Totaal opgehaald</span>
                        <span class="text-2xl font-bold text-gold">&euro;{{ number_format($teamTotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden mb-2">
                        <div class="bg-gradient-to-r from-gold to-gold-dark h-4 rounded-full transition-all duration-500" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                    <div class="text-sm text-slate-500">
                        Doel: &euro;{{ number_format($team->target_amount, 0, ',', '.') }} ({{ $percentage }}%)
                    </div>
                </div>

                <div class="border-t border-slate-300 pt-8">
                    <h2 class="text-2xl font-bold mb-6 title-gradient">Teamleden</h2>
                    @if (count($members) === 0)
                        <p class="text-slate-600">Nog geen teamleden</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($members as $member)
                                <div class="bg-white/80 rounded-lg p-4 border border-slate-300">
                                    <div class="text-slate-900 font-medium">{{ $member }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('home', ['team' => $team->id]) }}#doneer" class="btn btn-primary text-lg">
                        Doneer aan dit team
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
