# CLAUDE.md — Résidence Hôtel Cascades
## Site web avec moteur de réservation de chambres

---

## Présentation du projet

Site vitrine + moteur de réservation en ligne pour le **Résidence Hôtel Cascades**, résidence-hôtel située à Cocody, Abidjan, Côte d'Ivoire.

- **Stack** : LARAVEL BLADE · MYSQL · Brevo (emails)
- **Hébergement** : VPS Linux (OVH ou DigitalOcean) + Cloudflare CDN
- **Langue** : Français (principal) · Anglais (optionnel v2)
- **Paiement** : à l'arrivée — aucun paiement en ligne en v1

---

## Palette de couleurs

Extraite du logo : cascade cyan + typographie noire.

```css
:root {
  /* Primaires */
  --color-primary:      #42B6DA; /* cyan du logo — CTA, accents */
  --color-primary-dark: #2D9EC4; /* hover des CTA */
  --color-ink:          #0B1215; /* noir du logo — titres, structure, fonds sombres */

  /* Alias hérités (les vues utilisent encore ces noms) */
  --color-orange:      var(--color-primary);
  --color-orange-dark: var(--color-primary-dark);
  --color-navy:        var(--color-ink);
  --color-blue:        #1B7EA0; /* cyan foncé — liens lisibles sur blanc (AA) */

  /* Secondaires */
  --color-sky:         #D5F1FA; /* fonds légers, badges informatifs */
  --color-sand:        #BFE9F6; /* encarts highlight */

  /* Neutres */
  --color-white:       #FFFFFF;
  --color-snow:        #F8FAFC; /* fond pages intérieures */
  --color-slate:       #64748B; /* corps de texte, labels */
  --color-border:      #E2E8F0; /* bordures, séparateurs */
}
```

> Choix marque : les CTA cyan utilisent du texte **blanc** (décision du client,
> assumée malgré un contraste AA limite sur #42B6DA — graisse bold obligatoire).

### Règles d'usage

| Élément                  | Couleur à utiliser         |
|--------------------------|----------------------------|
| Bouton CTA principal     | `--color-orange`           |
| Bouton CTA hover         | `--color-orange-dark`      |
| Titres H1/H2             | `--color-navy`             |
| Liens et icônes          | `--color-blue`             |
| Corps de texte           | `--color-slate`            |
| Fond page intérieure     | `--color-snow`             |
| Fond hero / header       | `--color-navy`             |
| Badges / tags            | `--color-sky` + texte `#0F5E77` |
| Bordures / séparateurs   | `--color-border`           |

> **Règle simple** : cyan pour l'action (texte blanc en gras), noir pour la structure, cyan foncé pour les liens, slate pour le contenu.

---

## Architecture des pages

```
/                        → Accueil (hero + widget recherche + chambres vedettes)
/chambres                → Listing toutes les chambres
/chambres/[slug]         → Fiche détail chambre (galerie + calendrier + réservation)
/reservation             → Checkout (exige chambre + dates choisies, sinon redirection)
/reservation/confirmation → Page de confirmation post-réservation
/a-propos                → Histoire de l'établissement (inclut une section galerie)
/contact                 → Formulaire + carte + accès
/mentions-legales        → CGV + politique de confidentialité
```

### Back-office (routes protégées)

```
/admin                   → Tableau de bord (arrivées du jour, taux d'occupation)
/admin/reservations      → Liste et gestion des réservations
/admin/chambres          → Gestion du catalogue chambres
/admin/tarifs            → Règles tarifaires et saisons
```

---

## Modèle de données (résumé)

### `rooms` — Chambres

```ts
id, slug, name, description, capacity, size_m2,
bed_type, floor, view, amenities: string[],
price_per_night, status: 'active'|'inactive'|'maintenance',
images: string[], created_at
```

### `reservations` — Réservations

```ts
id, ref,           // ex: RHC-2026-0001
room_id,
guest_name, guest_email, guest_phone,
check_in, check_out, nights,
total_price,
special_requests,
status: 'confirmed'|'cancelled'|'modified',
created_at, cancelled_at
```

### `pricing_rules` — Règles tarifaires

```ts
id, name,          // ex: "Haute saison décembre"
start_date, end_date,
type: 'percentage'|'fixed',
adjustment,        // ex: +20 (%) ou +5000 (FCFA)
min_nights
```

### `blocked_dates` — Blocages manuels

```ts
id, room_id, start_date, end_date, reason
```

---

## Flux de réservation

```
1. Widget recherche (dates + personnes)
        ↓
2. Listing chambres disponibles (API /api/availability)
        ↓
3. Fiche chambre → sélection
        ↓
4. Checkout — séjour verrouillé en récap sidebar (prix serveur avec règles saisonnières, lien « Modifier »)
        ↓
5. Étape — Coordonnées (nom, email, tél, demandes)
        ↓
6. Étape — Confirmation (acceptation CGV)
        ↓
7. POST /api/reservations
        ↓
   ┌─────────────────────────────────┐
   │  Chambre bloquée en BDD        │
   │  Ref générée : RHC-YYYY-XXXX   │
   │  Email confirmation → client   │
   │  Email alerte → hôtel          │
   └─────────────────────────────────┘
        ↓
8. Page /reservation/confirmation
```

---

## Endpoints API principaux

```
GET  /api/availability?check_in=&check_out=&guests=
GET  /api/rooms
GET  /api/rooms/:slug
POST /api/reservations
GET  /api/reservations/:ref          (lien email client)
PUT  /api/reservations/:ref/cancel   (annulation client)

-- Back-office (auth requise) --
GET  /api/admin/reservations
PUT  /api/admin/reservations/:id
POST /api/admin/rooms
PUT  /api/admin/rooms/:id
POST /api/admin/blocked-dates
POST /api/admin/pricing-rules
```

---

## Emails transactionnels

| Déclencheur         | Destinataire | Objet                                      |
|---------------------|--------------|--------------------------------------------|
| Réservation créée   | Client       | Confirmation réservation RHC-YYYY-XXXX     |
| Réservation créée   | Hôtel        | Nouvelle réservation — [Nom client]        |
| J-1 avant arrivée   | Client       | Rappel : votre séjour commence demain      |
| Annulation client   | Client       | Annulation confirmée — RHC-YYYY-XXXX      |
| Annulation client   | Hôtel        | Annulation reçue — [Nom client]            |

---

## Architecture backend (obligatoire)

```
app/Http/Requests/          → FormRequests — TOUTE validation ici, jamais de $request->validate() inline
app/Services/               → Logique métier (ReservationService, RoomService, PricingService…)
app/Repositories/Contracts/ → Interfaces des repositories (ReservationRepositoryInterface…)
app/Repositories/Eloquent/  → Implémentations Eloquent, liées aux interfaces dans un ServiceProvider
app/Http/Controllers/       → Contrôleurs fins : injection du service, appel, réponse — zéro logique métier
```

- Contrôleur → FormRequest (validation) → Service (métier) → Repository (données).
- Les services dépendent des **interfaces** de repositories, pas des implémentations.
- Refactor complet effectué le 19/07/2026 : tout le code applicatif suit ce schéma.

## Conventions de code

- **Composants** : PascalCase (`RoomCard`, `BookingWidget`, `AvailabilityCalendar`)
- **Fichiers** : kebab-case (`room-card.tsx`, `booking-widget.tsx`)
- **Variables CSS** : `--color-*`, `--font-*`, `--radius-*`
- **API responses** : toujours `{ data, error, meta }` (meta pour la pagination)
- **Dates** : format ISO 8601 (`YYYY-MM-DD`) côté API, affichage localisé côté UI
- **Prix** : toujours en FCFA (entier), jamais de float pour les montants

---

## Règles métier importantes

- Une chambre ne peut pas être réservée si elle est déjà `confirmed` sur les mêmes dates
- Le calcul des nuits = `check_out - check_in` (la nuit du départ ne compte pas)
- Le prix affiché est toujours le prix total du séjour (nuits × tarif applicable)
- La politique d'annulation par défaut : gratuite jusqu'à 48h avant l'arrivée
- Aucun prépaiement — paiement intégral à l'arrivée
- Référence réservation : `RHC-{YEAR}-{4 chiffres séquentiels}` ex: `RHC-2026-0042`

---

## SEO — points clés

- Schema.org `LodgingBusiness` sur la page d'accueil
- Schema.org `HotelRoom` sur chaque fiche chambre
- Meta title pattern : `{Nom chambre} — Résidence Hôtel Cascades | Réservation en ligne`
- Alt text obligatoire sur toutes les images
- Sitemap XML généré automatiquement à chaque ajout de chambre

---

## Performance cible

| Métrique              | Cible          |
|-----------------------|----------------|
| LCP (mobile)          | < 2,5s         |
| PageSpeed mobile      | > 85           |
| PageSpeed desktop     | > 90           |
| Formats images        | WebP + lazy    |
| Uptime hébergement    | > 99,9 %       |

