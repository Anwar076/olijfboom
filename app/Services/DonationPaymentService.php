<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\Team;
use Mollie\Laravel\Facades\Mollie;

class DonationPaymentService
{
    public function createPayment(Donation $donation, Team $team, string $redirectUrl, string $webhookUrl)
    {
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format((float) $donation->amount, 2, '.', ''),
            ],
            'description' => "Donatie voor {$team->name}",
            'redirectUrl' => $redirectUrl,
            'webhookUrl' => $webhookUrl,
            'metadata' => [
                'donation_id' => $donation->id,
                'team_id' => $team->id,
            ],
        ]);

        $donation->update([
            'mollie_payment_id' => $payment->id,
        ]);

        return $payment;
    }

    public function syncDonationFromPayment(Donation $donation, $payment): Donation
    {
        $status = 'pending';
        $paidAt = null;

        if ($payment->isPaid()) {
            $status = 'paid';
            $paidAt = $donation->paid_at ?? now();
        } elseif ($payment->isCanceled() || $payment->isExpired() || $payment->isFailed()) {
            $status = 'failed';
        }

        $donation->fill([
            'status' => $status,
            'paid_at' => $paidAt,
        ])->save();

        return $donation;
    }
}
