<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTeamController extends Controller
{
    public function index(Request $request)
    {
        $limit = (int) ($request->query('limit', 100));
        $offset = (int) ($request->query('offset', 0));

        $teams = Team::query()
            ->leftJoin('donations', 'teams.id', '=', 'donations.team_id')
            ->select(
                'teams.id',
                'teams.name',
                'teams.target_label',
                'teams.target_amount',
                DB::raw('COALESCE(SUM(donations.amount), 0) as team_total')
            )
            ->groupBy('teams.id', 'teams.name', 'teams.target_label', 'teams.target_amount')
            ->orderByDesc('team_total')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $teamsWithStatus = $teams->map(function ($team) {
            $teamTotal = (float) $team->team_total;
            $targetAmount = (float) $team->target_amount;
            $lampStatus = $targetAmount > 0 && $teamTotal >= $targetAmount;
            $progressRatio = $targetAmount > 0 ? min(($teamTotal / $targetAmount) * 100, 100) : 0;

            return [
                'id' => $team->id,
                'name' => $team->name,
                'targetLabel' => $team->target_label,
                'targetAmount' => $targetAmount,
                'teamTotal' => $teamTotal,
                'lampStatus' => $lampStatus,
                'progressRatio' => $progressRatio,
            ];
        });

        return response()->json($teamsWithStatus);
    }

    public function showPublic(Team $team)
    {
        $members = DB::table('team_members')
            ->join('users', 'team_members.user_id', '=', 'users.id')
            ->where('team_members.team_id', $team->id)
            ->orderBy('team_members.created_at')
            ->pluck('users.name')
            ->toArray();

        $teamTotal = (float) (DB::table('donations')->where('team_id', $team->id)->sum('amount') ?? 0);
        $targetAmount = (float) $team->target_amount;
        $lampStatus = $targetAmount > 0 && $teamTotal >= $targetAmount;
        $progressRatio = $targetAmount > 0 ? min(($teamTotal / $targetAmount) * 100, 100) : 0;

        return response()->json([
            'id' => $team->id,
            'name' => $team->name,
            'description' => $team->description,
            'targetLabel' => $team->target_label,
            'targetAmount' => $targetAmount,
            'teamTotal' => $teamTotal,
            'lampStatus' => $lampStatus,
            'progressRatio' => $progressRatio,
            'members' => $members,
        ]);
    }
}
