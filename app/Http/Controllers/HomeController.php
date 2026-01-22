<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $totalRaised = (float) (DB::table('donations')->sum('amount') ?? 0);
        $lightsActivated = min((int) floor($totalRaised / 10000), 100);
        $totalLights = 100;
        $progressPercentage = $totalLights > 0 ? ($lightsActivated / $totalLights) * 100 : 0;

        $teams = Team::query()
            ->leftJoin('donations', 'teams.id', '=', 'donations.team_id')
            ->select('teams.*', DB::raw('COALESCE(SUM(donations.amount), 0) as team_total'))
            ->groupBy('teams.id')
            ->orderByDesc('team_total')
            ->get()
            ->map(function ($team) {
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

        return view('pages.home', [
            'totalRaised' => $totalRaised,
            'lightsActivated' => $lightsActivated,
            'totalLights' => $totalLights,
            'progressPercentage' => $progressPercentage,
            'teams' => $teams,
        ]);
    }
}
