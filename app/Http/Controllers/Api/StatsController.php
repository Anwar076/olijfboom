<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $totalRaised = (float) (DB::table('donations')->where('status', 'paid')->sum('amount') ?? 0);
        $lightsActivated = min((int) floor($totalRaised / 10000), 100);
        $totalLights = 100;
        $progressPercentage = $totalLights > 0 ? ($lightsActivated / $totalLights) * 100 : 0;

        $teamsCompleted = DB::table('teams')
            ->leftJoin('donations', function ($join) {
                $join->on('teams.id', '=', 'donations.team_id')
                    ->where('donations.status', '=', 'paid');
            })
            ->select('teams.id', 'teams.target_amount', DB::raw('COALESCE(SUM(donations.amount), 0) as team_total'))
            ->groupBy('teams.id', 'teams.target_amount')
            ->havingRaw('team_total >= teams.target_amount')
            ->get();

        $teamsCount = (int) (DB::table('teams')->count() ?? 0);
        $membersCount = (int) (DB::table('team_members')->count() ?? 0);

        return response()->json([
            'totalRaised' => $totalRaised,
            'lightsActivated' => $lightsActivated,
            'totalLights' => $totalLights,
            'progressPercentage' => $progressPercentage,
            'teamsCount' => $teamsCount,
            'membersCount' => $membersCount,
            'teamsCompleted' => $teamsCompleted->count(),
        ]);
    }
}
