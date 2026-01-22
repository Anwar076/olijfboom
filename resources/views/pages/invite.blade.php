@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @include('partials.header')

    <div class="pt-32 pb-20 px-4">
        <div class="container mx-auto max-w-md">
            @if ($error)
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-6 text-center">
                    {{ $error }}
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-gold hover:underline">Terug naar homepage</a>
                </div>
            @elseif ($expired ?? false)
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-6 text-center">
                    Deze uitnodiging is verlopen.
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-gold hover:underline">Terug naar homepage</a>
                </div>
            @elseif (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-6 text-center">
                    <h2 class="text-2xl font-bold mb-4">Succesvol toegevoegd!</h2>
                    <p>Je bent toegevoegd aan het team {{ $invite->team->name }}.</p>
                    <p class="mt-2 text-sm">Je wordt doorgestuurd naar de homepage...</p>
                </div>
                <script>
                    setTimeout(() => {
                        window.location.href = '{{ route('home') }}';
                    }, 2000);
                </script>
            @else
                <div class="bg-white/80 rounded-3xl p-8 md:p-12 border border-slate-200 backdrop-blur-sm">
                    <h1 class="text-4xl font-bold mb-4 title-gradient text-center">Uitnodiging Accepteren</h1>
                    <p class="text-center text-slate-600 mb-8">
                        Je bent uitgenodigd voor: <span class="text-gold font-semibold">{{ $invite->team->name }}</span>
                    </p>

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('invite.accept', ['token' => $invite->token]) }}" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-slate-700 mb-2 font-medium">Naam *</label>
                            <input type="text" name="name" required value="{{ old('name') }}" class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-2 font-medium">Email *</label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:border-gold focus:outline-none">
                        </div>
                        <button type="submit" class="btn btn-primary w-full text-lg">
                            Accepteren &amp; Lid worden
                        </button>
                        <p class="text-sm text-slate-600 text-center">
                            Als lid kun je niet inloggen. Je wordt alleen toegevoegd aan het team.
                        </p>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
