<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmation de réservation — Résidence Hôtel Cascades</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #F8FAFC; color: #0B1215; }
  .wrapper { max-width: 580px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: #0B1215; padding: 32px 40px; text-align: center; }
  .logo { display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: #42B6DA; border-radius: 12px; font-weight: 700; color: #fff; font-size: 16px; margin-bottom: 12px; }
  .header h1 { color: #fff; font-size: 22px; font-weight: 300; letter-spacing: .04em; }
  .header p { color: rgba(255,255,255,.6); font-size: 13px; margin-top: 4px; }
  .ref-badge { background: #FED7AA; color: #9a3412; font-family: monospace; font-size: 18px; font-weight: 700; text-align: center; padding: 16px 40px; letter-spacing: .1em; }
  .body { padding: 32px 40px; }
  .greeting { font-size: 16px; margin-bottom: 16px; color: #0B1215; }
  .intro { color: #64748B; font-size: 14px; line-height: 1.7; margin-bottom: 24px; }
  .details-card { background: #F8FAFC; border-radius: 12px; padding: 20px; margin-bottom: 24px; border: 1px solid #E2E8F0; }
  .details-card h2 { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: #64748B; margin-bottom: 14px; }
  .detail-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #E2E8F0; font-size: 14px; }
  .detail-row:last-child { border-bottom: none; }
  .detail-row .label { color: #64748B; }
  .detail-row .value { font-weight: 600; color: #0B1215; }
  .total-row { background: #0B1215; border-radius: 8px; padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
  .total-row .label { color: rgba(255,255,255,.7); font-size: 13px; }
  .total-row .value { color: #42B6DA; font-size: 20px; font-weight: 700; }
  .notice { background: #D5F1FA; border: 1px solid #FDE047; border-radius: 10px; padding: 16px; font-size: 13px; color: #713F12; line-height: 1.6; margin-bottom: 24px; }
  .notice strong { display: block; margin-bottom: 4px; }
  .cta-btn { display: block; background: #42B6DA; color: #fff !important; text-decoration: none; text-align: center; padding: 14px 32px; border-radius: 10px; font-weight: 600; font-size: 15px; margin-bottom: 12px; }
  .cancel-link { display: block; text-align: center; color: #64748B; font-size: 13px; text-decoration: none; margin-bottom: 24px; }
  .footer { background: #F8FAFC; padding: 24px 40px; border-top: 1px solid #E2E8F0; text-align: center; }
  .footer p { font-size: 12px; color: #94A3B8; line-height: 1.7; }
  .footer a { color: #0369A1; text-decoration: none; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <div class="logo">RHC</div>
    <h1>Résidence Hôtel Cascades</h1>
    <p>Résidence-Hôtel · Cocody, Abidjan</p>
  </div>

  <div class="ref-badge">Réservation {{ $reservation->ref }}</div>

  <div class="body">
    <p class="greeting">Bonjour {{ $reservation->guest_name }},</p>
    <p class="intro">Votre réservation à la Résidence Hôtel Cascades a bien été enregistrée. Nous avons hâte de vous accueillir dans notre résidence sur les rives de la lagune.</p>

    <div class="details-card">
      <h2>Détails du séjour</h2>
      <div class="detail-row">
        <span class="label">Chambre</span>
        <span class="value">{{ $reservation->room->name }}</span>
      </div>
      <div class="detail-row">
        <span class="label">Arrivée</span>
        <span class="value">{{ $reservation->check_in->format('d/m/Y') }}</span>
      </div>
      <div class="detail-row">
        <span class="label">Départ</span>
        <span class="value">{{ $reservation->check_out->format('d/m/Y') }}</span>
      </div>
      <div class="detail-row">
        <span class="label">Durée</span>
        <span class="value">{{ $reservation->nights }} nuit(s)</span>
      </div>
      <div class="detail-row">
        <span class="label">Voyageurs</span>
        <span class="value">{{ $reservation->guests }} personne(s)</span>
      </div>
    </div>

    <div class="total-row">
      <span class="label">Montant total à régler</span>
      <span class="value">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</span>
    </div>

    <div class="notice">
      <strong>Paiement à l'arrivée</strong>
      Le règlement s'effectue intégralement à la réception lors de votre arrivée. Aucune transaction en ligne n'est requise. Veuillez présenter cet email ou votre référence de réservation.
    </div>

    <a href="{{ route('reservation.confirmation', $reservation->ref) }}" class="cta-btn">Consulter ma réservation</a>
    <a href="{{ route('reservation.cancel', $reservation->cancel_token) }}" class="cancel-link">Annuler ma réservation (gratuit jusqu'à 48h avant l'arrivée)</a>
  </div>

  <div class="footer">
    <p>
      Résidence Hôtel Cascades · Cocody, Abidjan, Côte d'Ivoire<br>
      <a href="mailto:{{ config('mail.hotel_email') }}">{{ config('mail.hotel_email') }}</a><br><br>
      Vous recevez cet email car vous avez effectué une réservation sur notre site.
    </p>
  </div>
</div>
</body>
</html>
