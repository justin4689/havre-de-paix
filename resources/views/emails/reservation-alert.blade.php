<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Nouvelle réservation — {{ $reservation->ref }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #F8FAFC; color: #0B1215; }
  .wrapper { max-width: 540px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: #42B6DA; padding: 24px 36px; }
  .header h1 { color: #fff; font-size: 18px; font-weight: 700; }
  .header p { color: rgba(255,255,255,.8); font-size: 13px; margin-top: 4px; }
  .body { padding: 28px 36px; }
  .kv { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #E2E8F0; font-size: 14px; }
  .kv:last-child { border-bottom: none; }
  .kv .k { color: #64748B; }
  .kv .v { font-weight: 600; color: #0B1215; }
  .ref { font-family: monospace; font-size: 22px; font-weight: 700; color: #42B6DA; text-align: center; padding: 20px; background: #D5F1FA; border-radius: 10px; margin-bottom: 20px; letter-spacing: .08em; }
  .footer { padding: 20px 36px; border-top: 1px solid #E2E8F0; font-size: 12px; color: #94A3B8; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>Nouvelle réservation reçue</h1>
    <p>Résidence Hôtel Cascades — Back-office</p>
  </div>
  <div class="body">
    <div class="ref">{{ $reservation->ref }}</div>
    <div class="kv"><span class="k">Client</span><span class="v">{{ $reservation->guest_name }}</span></div>
    <div class="kv"><span class="k">Email</span><span class="v">{{ $reservation->guest_email }}</span></div>
    <div class="kv"><span class="k">Téléphone</span><span class="v">{{ $reservation->guest_phone }}</span></div>
    <div class="kv"><span class="k">Chambre</span><span class="v">{{ $reservation->room->name }}</span></div>
    <div class="kv"><span class="k">Arrivée</span><span class="v">{{ $reservation->check_in->format('d/m/Y') }}</span></div>
    <div class="kv"><span class="k">Départ</span><span class="v">{{ $reservation->check_out->format('d/m/Y') }}</span></div>
    <div class="kv"><span class="k">Nuits</span><span class="v">{{ $reservation->nights }}</span></div>
    <div class="kv"><span class="k">Voyageurs</span><span class="v">{{ $reservation->guests }}</span></div>
    <div class="kv"><span class="k">Montant total</span><span class="v" style="color:#42B6DA;">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</span></div>
    @if ($reservation->special_requests)
    <div class="kv"><span class="k">Demandes spéciales</span><span class="v">{{ $reservation->special_requests }}</span></div>
    @endif
  </div>
  <div class="footer">
    Résidence Hôtel Cascades · Cocody, Abidjan · Alerte automatique envoyée depuis le moteur de réservation.
  </div>
</div>
</body>
</html>
