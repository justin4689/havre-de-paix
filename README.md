<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Résidence Hôtel Cascades

Site vitrine + moteur de réservation — Laravel Blade · MySQL · Vite/Tailwind.

## Démarrage avec Docker

```bash
docker compose up -d
```

Au premier lancement, le conteneur `app` fait tout seul : création du `.env`,
`composer install`, génération de la clé, migrations et seed (chambres, comptes,
réservations de démo). Comptez quelques minutes la première fois.

| Service | URL / accès |
|---------|-------------|
| Site | http://localhost:8000 |
| Vite (HMR) | http://localhost:5173 (chargé automatiquement par les pages) |
| MySQL | `127.0.0.1:3306` — base `havre_de_paix`, user `havre` / `havre` |
| Admin seedé | `admin@residencehotelcascades.com` / `HDP@admin2024` |

Commandes courantes :

```bash
docker compose exec app php artisan migrate     # migrations
docker compose exec app php artisan test        # tests (Pest)
docker compose exec app php artisan tinker      # REPL
docker compose logs -f app queue vite           # logs
docker compose down                             # arrêt (ajouter -v pour vider la BDD)
```

Le code est monté en volume : les modifications PHP/Blade sont visibles au
rechargement, le CSS/JS est rechargé à chaud par Vite. Le `.env` est la source
de vérité : Laravel le lit directement, et `docker-compose.yml` y puise les
variables `DB_*` pour configurer le service MySQL.

## Déploiement production (VPS)

Pile dédiée [docker-compose.prod.yml](docker-compose.prod.yml) : image immuable
(code + vendor `--no-dev` + assets Vite compilés), PHP-FPM derrière Nginx,
queue `queue:work` et scheduler supervisés, MySQL non exposé, tout en `www-data`.

```bash
# Sur le VPS — première mise en place
cp .env.production.example .env          # puis compléter les CHANGER-MOI
docker compose -f docker-compose.prod.yml run --rm --no-deps app php artisan key:generate --show
                                         # → coller la clé dans APP_KEY du .env
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force

# Déploiement d'une nouvelle version
git pull
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

- Les caches Laravel (config/routes/vues) sont générés au démarrage du conteneur.
- Les migrations sont une étape de déploiement manuelle (ou `RUN_MIGRATIONS=1` dans le `.env`).
- Seuls les uploads (`storage/app/public`), les logs et MySQL vivent dans des volumes.
- TLS : à terminer en amont (Cloudflare ou reverse proxy du VPS) — Nginx écoute sur `HTTP_PORT` (80 par défaut).

---

## Emails transactionnels (Hostinger Mail API)

Les emails (confirmation/annulation de réservation, alertes hôtel, formulaire de
contact) partent via la [Hostinger Mail API](https://api.mail.hostinger.com/) —
pas de SMTP. L'expéditeur est la boîte `info@residencehotelcascades.com`.

**Architecture** — chaque couche est remplaçable indépendamment :

```
Action métier (réservation, contact)
        ↓
EmailService                  app/Services/EmailService.php   (façade métier, échec loggé jamais bloquant)
        ↓
Mailable ShouldQueue          app/Mail/*.php                  (3 tentatives, backoff 10 s puis 60 s)
        ↓  (worker `queue`)
HostingerMailTransport        app/Mail/Transport/…            (transport Symfony custom, retry sur 5xx)
        ↓
POST /api/v1/mailboxes/{id}/send
```

**Mise en place**

1. Créer le token : hPanel → Emails → residencehotelcascades.com → **Agentic mail → API**
   → « Create API token », scope *Selected mailboxes* limité à `info@` (copié une seule fois).
2. Récupérer l'identifiant de la boîte :
   ```bash
   curl -s https://api.mail.hostinger.com/api/v1/me -H "Authorization: Bearer $TOKEN"
   ```
3. Renseigner le `.env` :
   ```env
   MAIL_MAILER=hostinger
   HOSTINGER_MAIL_TOKEN=…
   HOSTINGER_MAIL_MAILBOX_ID=…
   ```
4. Tester :
   ```bash
   docker compose exec app php artisan tinker --execute='Mail::raw("Test", fn ($m) => $m->to("vous@exemple.com")->subject("Test API"));'
   docker compose exec app php artisan queue:work --once   # si le worker ne tourne pas déjà
   ```

Les templates étendent `resources/views/emails/layouts/main.blade.php` (en-tête
logo, palette de la marque, pied de page coordonnées). En dev, `MAIL_MAILER=log`
écrit les emails dans `storage/logs/laravel.log`. Les envois échoués trois fois
atterrissent dans `failed_jobs` (`php artisan queue:retry all` pour rejouer).

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
