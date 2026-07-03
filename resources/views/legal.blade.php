@extends('layouts.app')
@section('title', 'Mentions légales & CGV — Havre de Paix Assinie')
@section('content')
<div class="pt-20 pb-20">
    <div class="py-14 text-center" style="background-color: var(--color-navy);">
        <h1 class="text-4xl font-bold text-white" style="font-family: var(--font-serif);">Mentions légales & CGV</h1>
    </div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-16 prose prose-slate max-w-none">
        <h2>1. Mentions légales</h2>
        <p><strong>Dénomination :</strong> Havre de Paix — Résidence-Hôtel<br>
        <strong>Siège :</strong> Assinie Kilomètre 18,75, Côte d'Ivoire<br>
        <strong>Contact :</strong> contact@havredepaix-assinie.com</p>

        <h2>2. Conditions générales de vente</h2>
        <h3>2.1 Réservation</h3>
        <p>Toute réservation effectuée via ce site entraîne l'acceptation des présentes CGV. La réservation est confirmée dès réception de l'email de confirmation portant un numéro de référence unique (HDP-AAAA-XXXX).</p>
        <h3>2.2 Paiement</h3>
        <p>Le paiement s'effectue <strong>intégralement à l'arrivée</strong> à la réception de l'établissement. Aucune transaction financière en ligne n'est requise pour valider la réservation.</p>
        <h3>2.3 Politique d'annulation</h3>
        <p>L'annulation est <strong>gratuite jusqu'à 48h avant l'heure d'arrivée prévue</strong>. Toute annulation dans les 48h précédant l'arrivée entraîne la facturation d'une nuit de séjour à l'arrivée.</p>
        <h3>2.4 Modification</h3>
        <p>Toute demande de modification de dates ou de chambre doit être adressée à la réception par email ou téléphone, sous réserve de disponibilité.</p>

        <h2>3. Protection des données (RGPD)</h2>
        <p>Les données collectées (nom, email, téléphone) sont utilisées uniquement dans le cadre de la gestion des réservations. Elles ne sont pas cédées à des tiers. Conformément aux textes applicables en Côte d'Ivoire, vous disposez d'un droit d'accès, de rectification et de suppression de vos données en nous contactant à l'adresse ci-dessus.</p>
    </div>
</div>
@endsection
