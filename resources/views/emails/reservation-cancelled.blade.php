<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Annulation confirmée — {{ $reservation->ref }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #F8FAFC; color: #0B1215; }
  .wrapper { max-width: 540px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: #0B1215; padding: 28px 36px; text-align: center; }
  .header .icon { width: 48px; height: 48px; background: rgba(255,255,255,.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 22px; }
  .header h1 { color: #fff; font-size: 20px; }
  .header p { color: rgba(255,255,255,.6); font-size: 13px; margin-top: 6px; }
  .body { padding: 28px 36px; }
  .intro { color: #64748B; font-size: 14px; line-height: 1.7; margin-bottom: 20px; }
  .summary { background: #F8FAFC; border-radius: 10px; padding: 16px; border: 1px solid #E2E8F0; font-size: 14px; color: #64748B; margin-bottom: 20px; }
  .summary strong { color: #0B1215; }
  .cta { display: block; background: #42B6DA; color: #fff !important; text-decoration: none; text-align: center; padding: 13px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; margin-bottom: 20px; }
  .footer { padding: 20px 36px; border-top: 1px solid #E2E8F0; font-size: 12px; color: #94A3B8; text-align: center; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <div class="icon">✓</div>
    <h1>Annulation confirmée</h1>
    <p>Réservation {{ $reservation->ref }}</p>
  </div>
  <div class="body">
    <p class="intro">Bonjour {{ $reservation->guest_name }},<br><br>
    Votre demande d'annulation a bien été prise en compte. Votre réservation est désormais annulée.</p>

    <div class="summary">
      <p><strong>Chambre :</strong> {{ $reservation->room->name }}</p>
      <p><strong>Dates :</strong> {{ $reservation->check_in->format('d/m/Y') }} → {{ $reservation->check_out->format('d/m/Y') }}</p>
      <p><strong>Annulée le :</strong> {{ $reservation->cancelled_at ? $reservation->cancelled_at->format('d/m/Y à H:i') : now()->format('d/m/Y à H:i') }}</p>
    </div>

    <p style="font-size:14px;color:#64748B;line-height:1.7;margin-bottom:20px;">
      Nous espérons avoir l'occasion de vous accueillir prochainement à la Résidence Hôtel Cascades. N'hésitez pas à effectuer une nouvelle réservation sur notre site.
    </p>

    <a href="{{ route('rooms.index') }}" class="cta">Découvrir nos chambres</a>
  </div>
  <div class="footer">
    Résidence Hôtel Cascades · Cocody, Abidjan, Côte d'Ivoire<br>
    <a href="mailto:{{ config('mail.hotel_email') }}" style="color:#0369A1;">{{ config('mail.hotel_email') }}</a>
  </div>
</div>
</body>
</html>
