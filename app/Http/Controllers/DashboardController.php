<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $targetOptions = config('teams.targets', []);
        $user = $request->user();

        $membership = TeamMember::where('user_id', $user->id)->first();
        if (!$membership) {
            return view('pages.dashboard', [
                'team' => null,
                'members' => [],
                'teamTotal' => 0,
                'lampStatus' => false,
                'progressRatio' => 0,
                'inviteUrl' => session('invite_url'),
                'targetOptions' => $targetOptions,
            ]);
        }

        $team = Team::findOrFail($membership->team_id);

        $members = DB::table('team_members')
            ->join('users', 'team_members.user_id', '=', 'users.id')
            ->where('team_members.team_id', $team->id)
            ->orderBy('team_members.created_at')
            ->select('team_members.id', 'users.id as user_id', 'users.name', 'users.email', 'users.role')
            ->get();

        $teamTotal = (float) (DB::table('donations')
            ->where('team_id', $team->id)
            ->where('status', 'paid')
            ->sum('amount') ?? 0);
        $targetAmount = (float) $team->target_amount;
        $lampStatus = $targetAmount > 0 && $teamTotal >= $targetAmount;
        $progressRatio = $targetAmount > 0 ? min(($teamTotal / $targetAmount) * 100, 100) : 0;

        return view('pages.dashboard', [
            'team' => $team,
            'members' => $members,
            'teamTotal' => $teamTotal,
            'lampStatus' => $lampStatus,
            'progressRatio' => $progressRatio,
            'inviteUrl' => session('invite_url'),
            'targetOptions' => $targetOptions,
        ]);
    }

    public function createInvite(Request $request)
    {
        $user = $request->user();
        $teamId = TeamMember::where('user_id', $user->id)->value('team_id');

        if (!$teamId) {
            return redirect()->route('dashboard')->withErrors(['team' => 'Team niet gevonden.']);
        }

        $team = Team::findOrFail($teamId);

        if ($team->created_by_user_id !== $user->id) {
            abort(403, 'Not authorized for this team.');
        }

        $token = Str::random(64);

        Invite::create([
            'team_id' => $team->id,
            'token' => $token,
            'created_by_user_id' => $user->id,
            'expires_at' => now()->addDays(30),
        ]);

        $inviteUrl = route('invite.show', ['token' => $token]);

        return redirect()->route('dashboard')->with('invite_url', $inviteUrl);
    }

    public function addMember(Request $request)
    {
        $user = $request->user();
        $teamId = TeamMember::where('user_id', $user->id)->value('team_id');

        if (!$teamId) {
            return redirect()->route('dashboard')->withErrors(['team' => 'Team niet gevonden.']);
        }

        $team = Team::findOrFail($teamId);
        if ($team->created_by_user_id !== $user->id) {
            abort(403, 'Not authorized for this team.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $member = User::where('email', $data['email'])->first();

        if (!$member) {
            $member = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(32)),
                'role' => 'member',
            ]);
        } else {
            $member->update(['name' => $data['name']]);
        }

        $exists = TeamMember::where('team_id', $team->id)
            ->where('user_id', $member->id)
            ->exists();

        if (!$exists) {
            TeamMember::create([
                'team_id' => $team->id,
                'user_id' => $member->id,
            ]);
        }

        return redirect()->route('dashboard');
    }

    public function removeMember(Request $request, TeamMember $member)
    {
        $user = $request->user();
        $teamId = TeamMember::where('user_id', $user->id)->value('team_id');

        if (!$teamId) {
            return redirect()->route('dashboard')->withErrors(['team' => 'Team niet gevonden.']);
        }

        $team = Team::findOrFail($teamId);
        if ($team->created_by_user_id !== $user->id) {
            abort(403, 'Not authorized for this team.');
        }

        if ($member->team_id !== $team->id) {
            abort(403, 'Not authorized for this team.');
        }

        if ($member->user_id === $user->id) {
            return redirect()->route('dashboard')->withErrors(['member' => 'Je kunt jezelf niet verwijderen.']);
        }

        $member->delete();

        return redirect()->route('dashboard');
    }

    public function updateGoal(Request $request)
    {
        $user = $request->user();
        $teamId = TeamMember::where('user_id', $user->id)->value('team_id');

        if (!$teamId) {
            return redirect()->route('dashboard')->withErrors(['team' => 'Team niet gevonden.']);
        }

        $team = Team::findOrFail($teamId);
        if ($team->created_by_user_id !== $user->id) {
            abort(403, 'Not authorized for this team.');
        }

        if (!$request->filled('target_label') && $request->filled('target_option')) {
            $parts = explode('::', (string) $request->input('target_option'));
            if (count($parts) === 2) {
                $request->merge([
                    'target_label' => $parts[0],
                    'target_amount' => $parts[1],
                ]);
            }
        }

        $targetOptions = config('teams.targets', []);
        $validTargetOptions = collect($targetOptions)
            ->map(fn (array $option) => $option['label'] . '::' . $option['amount'])
            ->values()
            ->all();

        $data = $request->validate([
            'target_option' => ['required', 'string', Rule::in($validTargetOptions)],
            'target_label' => ['required', 'string', 'max:100'],
            'target_amount' => ['required', 'numeric', 'min:1'],
        ]);

        $team->update([
            'target_label' => $data['target_label'],
            'target_amount' => $data['target_amount'],
        ]);

        return redirect()->route('dashboard');
    }
}
