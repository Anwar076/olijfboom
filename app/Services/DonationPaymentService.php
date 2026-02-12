<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\Team;
use RuntimeException;
use Mollie\Laravel\Facades\Mollie;

class DonationPaymentService
{
    public function createPayment(Donation $donation, Team $team, string $redirectUrl, string $webhookUrl)
    {
        $mollieKey = trim((string) config('mollie.key'));
        if ($mollieKey === '') {
            throw new RuntimeException('MOLLIE_KEY is niet ingesteld.');
        }

        if (!filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('Redirect URL is ongeldig.');
        }

        if (!filter_var($webhookUrl, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('Webhook URL is ongeldig.');
        }

        if (app()->environment('production')) {
            if (!str_starts_with($redirectUrl, 'https://') || !str_starts_with($webhookUrl, 'https://')) {
                throw new RuntimeException('In productie moeten redirect/webhook URLs HTTPS gebruiken.');
            }
        }

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
