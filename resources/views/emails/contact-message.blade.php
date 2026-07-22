<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Nouveau message de contact — {{ $data['subject'] }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #F8FAFC; color: #0B1215; }
  .wrapper { max-width: 540px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: #0369A1; padding: 20px 32px; }
  .header h1 { color: #fff; font-size: 17px; font-weight: 700; }
  .header p { color: rgba(255,255,255,.75); font-size: 13px; margin-top: 3px; }
  .body { padding: 24px 32px; }
  .meta { background: #F0F9FF; border-radius: 10px; padding: 14px 16px; margin-bottom: 18px; border: 1px solid #BAE6FD; }
  .meta p { font-size: 13px; color: #0369A1; margin-bottom: 4px; }
  .meta p:last-child { margin-bottom: 0; }
  .meta strong { color: #0B1215; }
  .message-box { background: #F8FAFC; border-radius: 10px; padding: 16px; border: 1px solid #E2E8F0; font-size: 14px; color: #0B1215; line-height: 1.7; white-space: pre-line; }
  .footer { padding: 18px 32px; border-top: 1px solid #E2E8F0; font-size: 12px; color: #94A3B8; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>Nouveau message de contact</h1>
    <p>Résidence Hôtel Cascades — Formulaire de contact</p>
  </div>
  <div class="body">
    <div class="meta">
      <p><strong>De :</strong> {{ $data['name'] }}</p>
      <p><strong>Email :</strong> <a href="mailto:{{ $data['email'] }}" style="color:#0369A1;">{{ $data['email'] }}</a></p>
      <p><strong>Objet :</strong> {{ $data['subject'] }}</p>
      <p><strong>Reçu le :</strong> {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
    <div class="message-box">{{ $data['message'] }}</div>
  </div>
  <div class="footer">
    Résidence Hôtel Cascades · Cocody, Abidjan, Côte d'Ivoire · Message reçu via le formulaire de contact du site web.
  </div>
</div>
</body>
</html>
