@extends('emails.layouts.main')

@section('title', 'Nouveau message de contact — ' . $data['subject'])
@section('accent', '#1B7EA0')
@section('heading', 'Nouveau message de contact')
@section('subheading', 'Résidence Hôtel Cascades — Formulaire de contact')

@section('content')
    <div class="meta">
        <p><strong>De :</strong> {{ $data['name'] }}</p>
        <p><strong>Email :</strong> <a href="mailto:{{ $data['email'] }}" style="color:#0369A1;">{{ $data['email'] }}</a></p>
        <p><strong>Objet :</strong> {{ $data['subject'] }}</p>
        <p><strong>Reçu le :</strong> {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="message-box">{{ $data['message'] }}</div>
@endsection

@section('footer')
    <p>Message reçu via le formulaire de contact du site web. Répondez directement à l'expéditeur.</p>
@endsection
