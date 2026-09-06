# CLAUDE.md — Le Havre de Paix
## Site vitrine + moteur de réservation — Résidence-Hôtel à Assinie

---

## Présentation du projet

Site vitrine et moteur de réservation en ligne pour **Le Havre de Paix**, résidence-hôtel située à **Assinie, Kilomètre 18,75** (lagune Aby), Côte d'Ivoire. Architecture portée depuis le projet frère `havres-des-cascasdes` (Résidence Hôtel Cascades).

- **Stack** : Laravel 13 · Blade · Tailwind CSS 4 · Alpine.js · SQLite (dev) / MySQL (prod)
- **Langue** : Français (principal) · Anglais (bascule `/langue/en`, traductions dans `lang/en.json`)
- **Paiement** : à l'arrivée — aucun paiement en ligne en v1
- **Spécificités v1** : restaurant **pas encore ouvert** (petit-déjeuner inclus, servi au pavillon vitré) · piscine à débordement **commune**, sans surcoût

> ⚠️ **À compléter par le client** : téléphone (`HOTEL_PHONE`), WhatsApp (`HOTEL_WHATSAPP`), email réel (`HOTEL_EMAIL`), domaine définitif (placeholder actuel : `havredepaix-assinie.com`), position GPS exacte, RCCM dans les mentions légales.

---

## Palette de couleurs

Extraite du logo (soleil orange, ciel/lagune bleus, silhouettes noires). Définie dans `resources/css/app.css` (`@theme`).

```css
--color-primary:      #E8720C; /* orange soleil du logo — CTA, accents */
--color-primary-dark: #C55F06; /* hover des CTA */
--color-ink:          #10181C; /* noir du logo — titres, structure, fonds sombres */
--color-blue:         #1B7EA0; /* bleu lagune foncé — liens lisibles sur blanc (AA) */
--color-sky:          #D6EEF8; /* bleu ciel du logo — fonds légers, badges */
--color-sand:         #FCE8D2; /* halo orangé — encarts highlight, pastilles d'icônes */
--color-snow:         #F8FAFC; /* fond pages intérieures */
--color-slate:        #64748B; /* corps de texte */
--color-border:       #E2E8F0;
```

Les vues utilisent les **alias hérités** `--color-orange`, `--color-orange-dark`, `--color-navy` (mappés sur primary/ink) — ne pas les supprimer.

| Élément                | Couleur                    |
|------------------------|----------------------------|
| CTA principal          | orange (`--color-orange`), texte blanc gras |
| Titres H1/H2           | `--color-navy`             |
| Liens                  | `--color-blue`             |
| Prix                   | navy gras — jamais orange (l'orange reste réservé aux CTA) |
| Badges informatifs     | `--color-sky` + texte `#0F5E77` |
| Badges highlight       | `--color-sand` + texte `#8A4B06` |

**Typographie** : Figtree partout (façon Airbnb Cereal) — la hiérarchie vient de la graisse (700/800 titres), pas d'un changement de famille.

---

## Grille tarifaire (document « Tarifs Assinie 2026 »)

4 tarifs par chambre, stockés sur `rooms` :

| Colonne              | Rôle |
|----------------------|------|
| `price_per_night`    | basse saison, semaine — **prix « à partir de » affiché** |
| `price_high_season`  | haute saison, semaine |
| `price_weekend_low`  | vendredi/samedi, basse saison |
| `price_weekend_high` | vendredi/samedi, haute saison |

- **Haute saison** : Décembre–Mars et Juillet–Août (`config/hotel.php` → `high_season_ranges`, plages mois-jour récurrentes, la 1re chevauche le 1er janvier)
- **Nuits week-end** : vendredi et samedi (`weekend_nights` = [5, 6] ISO)
- `PricingService::priceForStay()` calcule **nuit par nuit** puis applique une éventuelle `pricing_rule` admin active (promo/majoration) sur le total
- Repli si grille incomplète : haute saison = basse saison ; week-end = +10 %

Grille en vigueur (FCFA/nuit — BS / HS / WE-BS / WE-HS) :

| Chambre           | Capacité | BS      | HS      | WE BS   | WE HS   |
|-------------------|----------|---------|---------|---------|---------|
| Standard (×2)     | 2 pers.  | 50 000  | 65 000  | 55 000  | 70 000  |
| Premium (×2)      | 2 pers.  | 60 000  | 75 000  | 66 000  | 85 000  |
| Suite             | 2–3      | 80 000  | 100 000 | 88 000  | 115 000 |
| Suite Premium     | 2–4      | 110 000 | 140 000 | 120 000 | 160 000 |
| Duplex (2 ch.)    | 4        | 90 000  | 120 000 | 100 000 | 140 000 |

Inclus partout : petit-déjeuner, WiFi, climatisation, piscine commune.

---

## Architecture backend (obligatoire)

```
app/Http/Requests/          → FormRequests — TOUTE validation ici, jamais de $request->validate() inline
app/Services/               → Logique métier (ReservationService, PricingService, AvailabilityService…)
app/Repositories/Contracts/ → Interfaces des repositories
app/Repositories/Eloquent/  → Implémentations Eloquent, liées dans RepositoryServiceProvider
app/Http/Controllers/       → Contrôleurs fins : injection du service, appel, réponse — zéro logique métier
```

- Contrôleur → FormRequest (validation) → Service (métier) → Repository (données).
- Les services dépendent des **interfaces** de repositories, pas des implémentations.

## Architecture des pages

```
/                         → Accueil (hero vidéo lagune + barre de recherche + chambres par catégorie)
/chambres                 → Catalogue filtrable (dates, capacité, catégorie, prix)
/chambres/{slug}          → Fiche chambre (galerie + carte de réservation sticky)
/reservation              → Tunnel (exige chambre + dates, prix calculé serveur)
/ma-reservation           → Retrouver / annuler sa réservation (throttlé)
/a-propos                 → Présentation, galerie, situation (Assinie), politique, FAQ
/notre-table (« Découvrir ») → Le domaine : piscine, pavillon, ponton, expériences
/contact · /mentions-legales
/admin/*                  → Back-office (dashboard, réservations, chambres, tarifs) — auth + AdminMiddleware
/api/availability         → Disponibilités (GET)
```

---

## Règles métier importantes

- Réf. réservation : `HDP-{YEAR}-{4 chiffres}` (ex. `HDP-2026-0042`) — générée dans `ReservationService::nextRef()`
- Nuits = `check_out - check_in` (la nuit du départ ne compte pas)
- Prix affiché = **total du séjour**, toujours calculé côté serveur
- Annulation gratuite jusqu'à 48 h avant l'arrivée (token dans l'email)
- Aucun prépaiement — règlement intégral à l'arrivée
- Prix en FCFA **entiers**, jamais de float
- Une chambre `confirmed` sur des dates chevauchantes n'est pas réservable (AvailabilityService)

---

## Médias

- **Sources brutes** : `public/images/Havre de Paix/` (203 photos iPhone 4032×3024) et `public/videos/*.MOV|MP4` — ne pas servir tel quel
- **Versions web** : `public/images/site/` (lieux) et `public/images/rooms/` (chambres), 1600 px max, EXIF appliqué — régénérables via un script PHP GD
- **Vidéos web** : `public/videos/hero.mp4` (lagune, paysage, hero accueil) et `visite.mp4` (verticale, section Immersion) — H.264 via `avconvert` (pas de ffmpeg sur la machine)
- Logo : `public/images/logo.png` (+ `logo-dashboard.png` pour l'admin)

## Comptes seedés (dev)

- Admin : `admin@havredepaix-assinie.com` / `HDP@admin2026`
- Réception : `reception@havredepaix-assinie.com` / `reception2026`

## Commandes

```sh
composer dev          # serve + queue + vite (npm requis : nvm use 24)
php artisan test      # Pest
php artisan migrate:fresh --seed
npm run build
```

> Note : `node`/`npm` viennent de nvm (`~/.nvm/versions/node/v24.18.0/bin`) — pas dans le PATH par défaut des shells non interactifs.

## i18n

Les chaînes sources sont en français dans les vues (`__('…')`). `lang/en.json` traduit par clé exacte : **toute modification d'une chaîne française casse sa traduction** — mettre à jour la clé correspondante. Les nouvelles chaînes (Assinie) n'ont pas encore de traduction EN : à compléter.

---

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application running on PHP 8.5. You are an expert with the Laravel ecosystem. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists (settled decisions, non-obvious traps, standing constraints). Framework and package guidelines that only apply to specific paths (testing, frontend, components) also live there, under `.ai/rules/boost` — this is not just recorded decisions, it is load-bearing guidance you have not seen inline. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.
- Record durable rules with `record-rule` so the next agent or teammate inherits them instead of working them out again. Pass a `glob` (e.g. `app/Http/Controllers/**`), a short `title`, and a few-line `note`. Always use `record-rule`, never your native memory or notes tool — native memory is personal and session-scoped; only `.ai/rules` is shared with the team and persists in the repo.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== tests rules ===

# Test Enforcement

- Test every code change by adding or updating a test.
- Run the affected tests and ensure they pass.
- Test the changed behavior and its important failure modes, but do not add tests beyond them.
- Read the `testing-best-practices` skill before writing tests.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

# Pest

- This project uses Pest. Create tests with `php artisan make:test --pest {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.
- Do not delete tests or test files without approval. They are part of the application.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/pest` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.
- After the feature tests pass, ask the user to run the complete suite with `php artisan test --compact`.

</laravel-boost-guidelines>
