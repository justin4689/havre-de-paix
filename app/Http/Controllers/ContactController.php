<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        try {
            Mail::to(config('mail.hotel_email', 'hotel@havredepaix-assinie.com'))
                ->send(new \App\Mail\ContactMessage($validated));
        } catch (\Exception $e) {
            logger()->error('Contact mail error: ' . $e->getMessage());
        }

        return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les 24h.');
    }
}
