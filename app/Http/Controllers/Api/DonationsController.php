<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Team;
use Illuminate\Http\Request;

class DonationsController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'team_id' => ['required', 'integer', 'exists:teams,id'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $team = Team::findOrFail($data['team_id']);
        $amount = (float) $data['amount'];

        Donation::create([
            'team_id' => $team->id,
            'amount' => $amount,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('home')
            ->with('donation_success', 'Donatie ontvangen! Bedankt voor uw bijdrage.');
    }
}
