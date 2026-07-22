<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Annulation — {{ $reservation->ref }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #F8FAFC; color: #0B1215; }
  .wrapper { max-width: 540px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: #DC2626; padding: 20px 32px; }
  .header h1 { color: #fff; font-size: 17px; font-weight: 700; }
  .header p { color: rgba(255,255,255,.75); font-size: 13px; margin-top: 3px; }
  .body { padding: 24px 32px; }
  .ref { font-family: monospace; font-size: 18px; font-weight: 700; color: #DC2626; text-align: center; padding: 14px; background: #FEF2F2; border-radius: 8px; margin-bottom: 18px; }
  .kv { display: flex; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid #E2E8F0; font-size: 14px; }
  .kv:last-child { border-bottom: none; }
  .kv .k { color: #64748B; }
  .kv .v { font-weight: 600; color: #0B1215; }
  .footer { padding: 18px 32px; border-top: 1px solid #E2E8F0; font-size: 12px; color: #94A3B8; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>Réservation annulée</h1>
    <p>Résidence Hôtel Cascades — Back-office</p>
  </div>
  <div class="body">
    <div class="ref">{{ $reservation->ref }}</div>
    <div class="kv"><span class="k">Client</span><span class="v">{{ $reservation->guest_name }}</span></div>
    <div class="kv"><span class="k">Email</span><span class="v">{{ $reservation->guest_email }}</span></div>
    <div class="kv"><span class="k">Chambre</span><span class="v">{{ $reservation->room->name }}</span></div>
    <div class="kv"><span class="k">Dates</span><span class="v">{{ $reservation->check_in->format('d/m/Y') }} → {{ $reservation->check_out->format('d/m/Y') }}</span></div>
    <div class="kv"><span class="k">Annulée le</span><span class="v">{{ $reservation->cancelled_at ? $reservation->cancelled_at->format('d/m/Y à H:i') : now()->format('d/m/Y à H:i') }}</span></div>
  </div>
  <div class="footer">Alerte automatique — La chambre est désormais disponible pour ces dates.</div>
</div>
</body>
</html>
