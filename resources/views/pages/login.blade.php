@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')
    <div class="pt-32 pb-20 px-4">
        <div class="container mx-auto max-w-md">
            <div class="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
                <h1 class="text-4xl font-bold mb-8 title-gradient text-center">Inloggen</h1>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-slate-700 mb-2 font-medium">Email</label>
                        <input
                            type="email"
                            name="email"
                            required
                            value="{{ old('email') }}"
                            class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                        />
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-2 font-medium">Wachtwoord</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none"
                        />
                    </div>

                    <button type="submit" class="btn btn-primary w-full text-lg">
                        Inloggen
                    </button>
                </form>

                <div class="mt-6 text-center text-slate-600">
                    <p>
                        Nog geen team?
                        <a href="{{ route('teams.create') }}" class="text-gold hover:underline">Start een team</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
