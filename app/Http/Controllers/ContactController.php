<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\ContactService;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService,
    ) {}

    public function index()
    {
        return view('contact');
    }

    public function send(ContactRequest $request)
    {
        $this->contactService->send($request->validated());

        return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les 24h.');
    }
}
