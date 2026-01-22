<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeamController extends Controller
{
    public function create()
    {
        $targetOptions = [
            ['label' => 'Blad', 'amount' => 5000],
            ['label' => 'Blad', 'amount' => 10000],
            ['label' => 'Olijf', 'amount' => 25000],
            ['label' => 'Wortel', 'amount' => 50000],
            ['label' => 'Tak', 'amount' => 100000],
            ['label' => 'Stam', 'amount' => 200000],
        ];

        return view('pages.create-team', [
            'targetOptions' => $targetOptions,
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->filled('target_label') && $request->filled('target_option')) {
            $parts = explode('::', (string) $request->input('target_option'));
            if (count($parts) === 2) {
                $request->merge([
                    'target_label' => $parts[0],
                    'target_amount' => $parts[1],
                ]);
            }
        }

        $data = $request->validate([
            'team_name' => ['required', 'string', 'max:255'],
            'team_description' => ['nullable', 'string'],
            'target_option' => ['required', 'string'],
            'target_label' => ['required', 'string', 'max:100'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'admin',
            ]);

            $team = Team::create([
                'name' => $data['team_name'],
                'description' => $data['team_description'] ?? null,
                'target_label' => $data['target_label'],
                'target_amount' => $data['target_amount'],
                'created_by_user_id' => $user->id,
            ]);

            TeamMember::create([
                'team_id' => $team->id,
                'user_id' => $user->id,
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
        });
    }

    public function show(Team $team)
    {
        $members = DB::table('team_members')
            ->join('users', 'team_members.user_id', '=', 'users.id')
            ->where('team_members.team_id', $team->id)
            ->orderBy('team_members.created_at')
            ->pluck('users.name')
            ->toArray();

        $teamTotal = (float) (DB::table('donations')
            ->where('team_id', $team->id)
            ->where('status', 'paid')
            ->sum('amount') ?? 0);
        $targetAmount = (float) $team->target_amount;
        $lampStatus = $targetAmount > 0 && $teamTotal >= $targetAmount;
        $progressRatio = $targetAmount > 0 ? min(($teamTotal / $targetAmount) * 100, 100) : 0;

        return view('pages.team-detail', [
            'team' => $team,
            'members' => $members,
            'teamTotal' => $teamTotal,
            'lampStatus' => $lampStatus,
            'progressRatio' => $progressRatio,
        ]);
    }
}
