<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Team;
use App\Services\DonationPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;

class DonationsController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'team_id' => ['required', 'integer', 'exists:teams,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'dua_request_enabled' => ['nullable', 'boolean'],
            'dua_request_text' => ['nullable', 'string', 'max:255'],
        ]);

        $team = Team::findOrFail($data['team_id']);
        $amount = (float) $data['amount'];

        $donation = Donation::create([
            'team_id' => $team->id,
            'amount' => $amount,
            'status' => 'pending',
            'dua_request_enabled' => (bool) ($data['dua_request_enabled'] ?? false),
            'dua_request_text' => $data['dua_request_text'] ?? null,
        ]);

        // In de lokale ontwikkelomgeving slaan we Mollie over
        // en markeren we de donatie direct als "betaald",
        // zodat o.a. dua-verzoeken getest kunnen worden.
        if (config('app.env') === 'local') {
            $donation->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            return redirect()
                ->route('home')
                ->with('donation_success', 'Testdonatie geregistreerd (lokale omgeving).');
        }

        try {
            $payment = app(DonationPaymentService::class)->createPayment(
                $donation,
                $team,
                route('donations.return', ['donation' => $donation->id]),
                route('donations.webhook')
            );
        } catch (\Throwable $error) {
            Log::error('Donatiebetaling starten mislukt', [
                'donation_id' => $donation->id,
                'team_id' => $team->id,
                'amount' => $amount,
                'redirect_url' => route('donations.return', ['donation' => $donation->id]),
                'webhook_url' => route('donations.webhook'),
                'exception_class' => get_class($error),
                'exception_message' => $error->getMessage(),
            ]);

            $donation->update(['status' => 'failed']);

            return back()->withErrors(['donation' => 'Betaling kon niet worden gestart. Probeer het opnieuw.']);
        }

        return redirect()->away($payment->getCheckoutUrl());
    }

    public function handleReturn(Donation $donation)
    {
        if (!$donation->mollie_payment_id) {
            return redirect()->route('home')
                ->withErrors(['donation' => 'Betaling kon niet worden gecontroleerd.']);
        }

        try {
            $payment = Mollie::api()->payments->get($donation->mollie_payment_id);
        } catch (\Throwable $error) {
            return redirect()->route('home')
                ->withErrors(['donation' => 'Betaling kon niet worden gecontroleerd.']);
        }

        $donation = app(DonationPaymentService::class)->syncDonationFromPayment($donation, $payment);

        if ($donation->status === 'paid') {
            return redirect()->route('home')
                ->with('donation_success', 'Donatie ontvangen! Bedankt voor uw bijdrage.');
        }

        if ($donation->status === 'failed') {
            return redirect()->route('home')
                ->withErrors(['donation' => 'Betaling is geannuleerd of mislukt.']);
        }

        return redirect()->route('home')
            ->withErrors(['donation' => 'Betaling is in behandeling.']);
    }

    public function webhook(Request $request)
    {
        $paymentId = (string) $request->input('id');

        if ($paymentId === '') {
            return response('Missing payment id', 400);
        }

        try {
            $payment = Mollie::api()->payments->get($paymentId);
        } catch (\Throwable $error) {
            return response('Payment lookup failed', 500);
        }
        $donationId = $payment->metadata->donation_id ?? null;

        $donation = Donation::where('mollie_payment_id', $paymentId)->first();
        if (!$donation && $donationId) {
            $donation = Donation::find($donationId);
        }

        if (!$donation) {
            return response('Donation not found', 404);
        }

        app(DonationPaymentService::class)->syncDonationFromPayment($donation, $payment);

        return response('OK', 200);
    }
}
