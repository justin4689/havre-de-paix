@extends('layouts.app')
@section('title', 'Contact — Havre de Paix Assinie')
@section('hero_nav', '1')
@section('content')
<div>
    <div class="relative flex items-center justify-center text-center h-[60vh] min-h-[420px] px-4 overflow-hidden">
        <img src="{{ asset('images/contact-hero.jpg') }}" alt="Plage d'Assinie au coucher du soleil"
             class="absolute inset-0 w-full h-full object-cover" loading="eager">
        <div class="absolute inset-0 hero-overlay"></div>
        <div class="relative z-10 pt-16">
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-3" style="font-family: var(--font-serif);">Contact</h1>
            <p style="color: rgba(255,255,255,0.85);">Nous sommes à votre écoute</p>
        </div>
    </div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Formulaire --}}
            <div>
                @if (session('success'))
                <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                <h2 class="section-title mb-6">Envoyer un message</h2>
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="form-label">Nom complet <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" required autocomplete="name">
                    </div>
                    <div>
                        <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" required autocomplete="email">
                    </div>
                    <div>
                        <label for="subject" class="form-label">Objet <span class="text-red-500">*</span></label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="form-input" required>
                    </div>
                    <div>
                        <label for="message" class="form-label">Message <span class="text-red-500">*</span></label>
                        <textarea name="message" id="message" rows="5" class="form-input resize-none" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full py-3.5">Envoyer le message</button>
                </form>
            </div>

            {{-- Infos --}}
            <div>
                <h2 class="section-title mb-6">Nos coordonnées</h2>
                <div class="space-y-5">
                    @foreach ([
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Adresse', 'text' => 'Assinie Kilomètre 18,75<br>Côte d\'Ivoire, Afrique de l\'Ouest'],
                        ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title' => 'Téléphone', 'text' => '+225 XX XX XX XX XX'],
                        ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Email', 'text' => 'contact@havredepaix-assinie.com'],
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Horaires réception', 'text' => 'Lundi – Dimanche : 7h00 – 22h00'],
                    ] as $info)
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--color-sand);">
                            <svg class="w-5 h-5" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm mb-0.5" style="color: var(--color-navy);">{{ $info['title'] }}</p>
                            <p class="text-sm" style="color: var(--color-slate);">{!! $info['text'] !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- WhatsApp --}}
                <div class="mt-8">
                    <a href="https://wa.me/2250000000000?text=Bonjour,%20je%20souhaite%20des%20informations%20sur%20le%20Havre%20de%20Paix"
                       target="_blank" rel="noopener"
                       class="btn-primary w-full justify-center" style="background-color: #25D366;">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Écrire sur WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
