<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LightsController extends Controller
{
    public function show(int $lightIndex)
    {
        if ($lightIndex < 0 || $lightIndex >= 100) {
            return response()->json(['error' => 'Invalid light index (0-99)'], 400);
        }

        $lightStartAmount = $lightIndex * 10000;
        $lightEndAmount = ($lightIndex + 1) * 10000;

        $allDonations = DB::table('donations')
            ->join('teams', 'donations.team_id', '=', 'teams.id')
            ->where('donations.status', 'paid')
            ->orderBy('donations.paid_at')
            ->orderBy('donations.id')
            ->select(
                'donations.id',
                'donations.team_id',
                'donations.amount',
                'donations.created_at',
                'teams.name as team_name'
            )
            ->get();

        $cumulativeTotal = 0;
        $contributing = [];

        foreach ($allDonations as $donation) {
            $donationAmount = (float) $donation->amount;
            $prevTotal = $cumulativeTotal;
            $cumulativeTotal += $donationAmount;

            if ($prevTotal < $lightEndAmount && $cumulativeTotal > $lightStartAmount) {
                $contributionStart = max($prevTotal, $lightStartAmount);
                $contributionEnd = min($cumulativeTotal, $lightEndAmount);
                $contributionAmount = $contributionEnd - $contributionStart;

                $contributing[] = [
                    'teamId' => $donation->team_id,
                    'teamName' => $donation->team_name,
                    'amount' => $contributionAmount,
                    'donationDate' => $donation->created_at,
                ];
            }

            if ($cumulativeTotal >= $lightEndAmount) {
                break;
            }
        }

        $teamContributions = [];
        foreach ($contributing as $contribution) {
            $teamId = $contribution['teamId'];
            if (!isset($teamContributions[$teamId])) {
                $teamContributions[$teamId] = [
                    'teamName' => $contribution['teamName'],
                    'totalAmount' => 0,
                ];
            }
            $teamContributions[$teamId]['totalAmount'] += $contribution['amount'];
        }

        $teams = collect($teamContributions)->map(function ($data) {
            return [
                'teamName' => $data['teamName'],
                'amount' => round($data['totalAmount'], 2),
            ];
        })->values();

        return response()->json([
            'lightIndex' => $lightIndex,
            'lightNumber' => $lightIndex + 1,
            'amountRange' => [
                'start' => $lightStartAmount,
                'end' => $lightEndAmount,
            ],
            'teams' => $teams,
        ]);
    }
}
