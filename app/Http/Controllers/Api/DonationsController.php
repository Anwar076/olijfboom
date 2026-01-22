<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Team;
use App\Services\DonationPaymentService;
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

        $donation = Donation::create([
            'team_id' => $team->id,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        try {
            $payment = app(DonationPaymentService::class)->createPayment(
                $donation,
                $team,
                route('donations.return', ['donation' => $donation->id]),
                route('donations.webhook')
            );
        } catch (\Throwable $error) {
            $donation->update(['status' => 'failed']);

            return response()->json([
                'success' => false,
                'message' => 'Betaling kon niet worden gestart.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'donationId' => $donation->id,
            'checkoutUrl' => $payment->getCheckoutUrl(),
        ]);
    }
}
