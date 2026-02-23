<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submitSponsoring(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        Mail::send('emails.sponsoring', ['data' => $data], function ($message) use ($data) {
            $message->to('anwar@brancom.nl')
                ->subject('Nieuw sponsoraanvraag Olijfboom van Licht')
                ->replyTo($data['email'], $data['name']);
        });

        return redirect()->route('home')->with('status', 'Bedankt, we hebben je sponsorverzoek ontvangen.');
    }

    public function submitActionPhotos(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'team_name' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['nullable', 'file', 'image', 'max:5120'],
        ]);

        $photos = $request->file('photos', []);

        Mail::send('emails.action_photos', ['data' => $data, 'photoCount' => count($photos)], function ($message) use ($data, $photos) {
            $message->to('anwar@brancom.nl')
                ->subject('Nieuwe actie-inzending Olijfboom van Licht')
                ->replyTo($data['email'], $data['name']);

            foreach ($photos as $index => $photo) {
                if ($photo && $photo->isValid()) {
                    $message->attach($photo->getRealPath(), [
                        'as' => $photo->getClientOriginalName(),
                        'mime' => $photo->getMimeType(),
                    ]);
                }
            }
        });

        return redirect()->route('home')->with('status', 'Bedankt, we hebben je actie en foto\'s ontvangen.');
    }
}

