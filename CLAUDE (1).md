# CLAUDE.md — Havre de Paix Assinie
## Site web avec moteur de réservation de chambres

---

## Présentation du projet

Site vitrine + moteur de réservation en ligne pour le **Havre de Paix**, résidence-hôtel située à Assinie Kilomètre 18,75, Côte d'Ivoire.

- **Stack** : LARAVEL BLADE · MYSQL · Brevo (emails)
- **Hébergement** : VPS Linux (OVH ou DigitalOcean) + Cloudflare CDN
- **Langue** : Français (principal) · Anglais (optionnel v2)
- **Paiement** : à l'arrivée — aucun paiement en ligne en v1

---

## Palette de couleurs

Extraite du logo : soleil orange + lagon bleu + silhouettes nuit.

```css
:root {
  /* Primaires */
  --color-orange:      #F97316; /* CTA, boutons principaux, accents */
  --color-orange-dark: #EA580C; /* hover des boutons orange */
  --color-navy:        #1E293B; /* textes titres, fond hero, navigation */
  --color-blue:        #0369A1; /* liens, icônes, éléments secondaires */

  /* Secondaires */
  --color-sky:         #BAE6FD; /* fonds légers, badges informatifs */
  --color-sand:        #FED7AA; /* encarts promo, highlights doux */

  /* Neutres */
  --color-white:       #FFFFFF;
  --color-snow:        #F8FAFC; /* fond pages intérieures */
  --color-slate:       #64748B; /* corps de texte, labels */
  --color-border:      #E2E8F0; /* bordures, séparateurs */
}
```

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
| Badges / tags            | `--color-sky` + texte `#075985` |
| Bordures / séparateurs   | `--color-border`           |

> **Règle simple** : orange pour l'action, navy pour la structure, bleu pour l'information, slate pour le contenu.

---

## Architecture des pages

```
/                        → Accueil (hero + widget recherche + chambres vedettes)
/chambres                → Listing toutes les chambres
/chambres/[slug]         → Fiche détail chambre (galerie + calendrier + réservation)
/reservation             → Tunnel de réservation (3 étapes)
/reservation/confirmation → Page de confirmation post-réservation
/a-propos                → Histoire de l'établissement
/galerie                 → Galerie photo
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
id, ref,           // ex: HDP-2026-0001
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
4. Étape 1 — Récapitulatif (chambre, dates, prix total)
        ↓
5. Étape 2 — Coordonnées (nom, email, tél, demandes)
        ↓
6. Étape 3 — Confirmation (acceptation CGV)
        ↓
7. POST /api/reservations
        ↓
   ┌─────────────────────────────────┐
   │  Chambre bloquée en BDD        │
   │  Ref générée : HDP-YYYY-XXXX   │
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
| Réservation créée   | Client       | Confirmation réservation HDP-YYYY-XXXX     |
| Réservation créée   | Hôtel        | Nouvelle réservation — [Nom client]        |
| J-1 avant arrivée   | Client       | Rappel : votre séjour commence demain      |
| Annulation client   | Client       | Annulation confirmée — HDP-YYYY-XXXX      |
| Annulation client   | Hôtel        | Annulation reçue — [Nom client]            |

---

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
- Référence réservation : `HDP-{YEAR}-{4 chiffres séquentiels}` ex: `HDP-2026-0042`

---

## SEO — points clés

- Schema.org `LodgingBusiness` sur la page d'accueil
- Schema.org `HotelRoom` sur chaque fiche chambre
- Meta title pattern : `{Nom chambre} — Havre de Paix Assinie | Réservation en ligne`
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

