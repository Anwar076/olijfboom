<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function show(string $token)
    {
        $invite = Invite::with('team')
            ->where('token', $token)
            ->first();

        if (!$invite) {
            return view('pages.invite', [
                'invite' => null,
                'error' => 'Ongeldige uitnodigingslink',
            ]);
        }

        $expired = $invite->expires_at && $invite->expires_at->isPast();

        return view('pages.invite', [
            'invite' => $invite,
            'error' => null,
            'expired' => $expired,
        ]);
    }

    public function accept(Request $request, string $token)
    {
        $invite = Invite::with('team')
            ->where('token', $token)
            ->first();

        if (!$invite) {
            return redirect()->route('invite.show', ['token' => $token])
                ->withErrors(['invite' => 'Ongeldige uitnodigingslink']);
        }

        if ($invite->used_at) {
            return redirect()->route('invite.show', ['token' => $token])
                ->withErrors(['invite' => 'Uitnodiging is al gebruikt']);
        }

        if ($invite->expires_at && $invite->expires_at->isPast()) {
            return redirect()->route('invite.show', ['token' => $token])
                ->withErrors(['invite' => 'Uitnodiging is verlopen']);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(32)),
                'role' => User::ROLE_USER,
            ]);
        } else {
            $user->update(['name' => $data['name']]);
        }

        $exists = TeamMember::where('team_id', $invite->team_id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$exists) {
            TeamMember::create([
                'team_id' => $invite->team_id,
                'user_id' => $user->id,
            ]);
        }

        $invite->update(['used_at' => now()]);

        return redirect()->route('invite.show', ['token' => $token])
            ->with('success', 'Je bent toegevoegd aan het team!');
    }
}
