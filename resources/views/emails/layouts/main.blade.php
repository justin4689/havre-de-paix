{{--
    Layout commun des emails transactionnels.

    Sections :
      title      — <title> du document
      accent     — couleur du bandeau d'en-tête (défaut : noir marque)
      logo       — présent = affiche la pastille logo (emails clients)
      heading    — titre de l'en-tête
      subheading — sous-titre de l'en-tête
      content    — corps de l'email
      footer     — pied de page (défaut : coordonnées de l'hôtel)

    Styles inline dans <head> : compatibilité maximale clients mail.
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Résidence Hôtel Cascades')</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #F8FAFC; color: #0B1215; }
  .wrapper { max-width: 580px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { padding: 28px 36px; text-align: center; }
  .logo-img { width: 56px; height: 56px; border-radius: 12px; margin-bottom: 12px; }
  .header h1 { color: #fff; font-size: 20px; font-weight: 600; letter-spacing: .02em; }
  .header p { color: rgba(255,255,255,.65); font-size: 13px; margin-top: 5px; }
  .body { padding: 28px 36px; }
  .greeting { font-size: 16px; margin-bottom: 16px; color: #0B1215; }
  .intro { color: #64748B; font-size: 14px; line-height: 1.7; margin-bottom: 22px; }
  .ref-badge { background: #D5F1FA; color: #0F5E77; font-family: monospace; font-size: 18px; font-weight: 700; text-align: center; padding: 16px; border-radius: 10px; letter-spacing: .1em; margin-bottom: 22px; }
  .ref-badge.danger { background: #FEF2F2; color: #DC2626; }
  .details-card { background: #F8FAFC; border-radius: 12px; padding: 20px; margin-bottom: 22px; border: 1px solid #E2E8F0; }
  .details-card h2 { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: #64748B; margin-bottom: 12px; }
  /* Lignes libellé/valeur : tableaux (flexbox non supporté par Gmail & co) */
  .kv-table { width: 100%; border-collapse: collapse; }
  .kv-table td { padding: 9px 0; border-bottom: 1px solid #E2E8F0; font-size: 14px; }
  .kv-table tr:last-child td { border-bottom: none; }
  .kv-table .k { color: #64748B; text-align: left; }
  .kv-table .v { font-weight: 600; color: #0B1215; text-align: right; }
  .total-table { width: 100%; border-collapse: separate; background: #0B1215; border-radius: 8px; margin-bottom: 22px; }
  .total-table td { padding: 14px 16px; }
  .total-table .label { color: rgba(255,255,255,.7); font-size: 13px; text-align: left; }
  .total-table .value { color: #42B6DA; font-size: 20px; font-weight: 700; text-align: right; }
  .notice { background: #D5F1FA; border: 1px solid #BFE9F6; border-radius: 10px; padding: 16px; font-size: 13px; color: #0F5E77; line-height: 1.6; margin-bottom: 22px; }
  .notice strong { display: block; margin-bottom: 4px; color: #0B1215; }
  .summary { background: #F8FAFC; border-radius: 10px; padding: 16px; border: 1px solid #E2E8F0; font-size: 14px; color: #64748B; margin-bottom: 20px; line-height: 1.8; }
  .summary strong { color: #0B1215; }
  .meta { background: #F0F9FF; border-radius: 10px; padding: 14px 16px; margin-bottom: 18px; border: 1px solid #BAE6FD; }
  .meta p { font-size: 13px; color: #0369A1; margin-bottom: 4px; }
  .meta p:last-child { margin-bottom: 0; }
  .meta strong { color: #0B1215; }
  .message-box { background: #F8FAFC; border-radius: 10px; padding: 16px; border: 1px solid #E2E8F0; font-size: 14px; color: #0B1215; line-height: 1.7; white-space: pre-line; }
  .cta-btn { display: block; background: #42B6DA; color: #fff !important; text-decoration: none; text-align: center; padding: 14px 32px; border-radius: 10px; font-weight: 600; font-size: 15px; margin-bottom: 12px; }
  .cancel-link { display: block; text-align: center; color: #64748B; font-size: 13px; text-decoration: none; margin-bottom: 12px; }
  .footer { background: #F8FAFC; padding: 22px 36px; border-top: 1px solid #E2E8F0; text-align: center; }
  .footer p { font-size: 12px; color: #94A3B8; line-height: 1.7; }
  .footer a { color: #0369A1; text-decoration: none; }
</style>
</head>
<body>
<div class="wrapper">
    <div class="header" style="background: @yield('accent', '#0B1215');">
        @hasSection('logo')
        <img src="{{ asset('images/logo-dashboard.png') }}" alt="Résidence Hôtel Cascades" width="56" height="56" class="logo-img">
        @endif
        <h1>@yield('heading')</h1>
        <p>@yield('subheading')</p>
    </div>

    <div class="body">
        @yield('content')
    </div>

    <div class="footer">
        @section('footer')
        <p>
            Résidence Hôtel Cascades · Cocody Riviera — M'Badon, Abidjan, Côte d'Ivoire<br>
            <a href="mailto:{{ config('mail.hotel_email') }}">{{ config('mail.hotel_email') }}</a> · +225 05 06 50 55 92
        </p>
        @show
    </div>
</div>
</body>
</html>
