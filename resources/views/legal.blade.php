@extends('layouts.app')

@section('title', 'Mentions légales, CGV & Confidentialité — Havre de Paix Assinie')
@section('description', 'Mentions légales, conditions générales de vente et politique de confidentialité du Havre de Paix, résidence-hôtel à Assinie, Côte d\'Ivoire.')

@section('content')
<div class="pt-20 pb-20" style="background-color: var(--color-snow);">

    {{-- Header --}}
    <div class="py-14 px-4 text-center" style="background-color: var(--color-navy);">
        <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight mb-3">Informations légales</h1>
        <p class="max-w-xl mx-auto text-sm" style="color: rgba(255,255,255,0.7);">
            Mentions légales, conditions générales de vente et politique de confidentialité.
        </p>
        <p class="mt-3 text-xs" style="color: rgba(255,255,255,0.5);">Dernière mise à jour : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10 items-start">

            {{-- Sommaire sticky --}}
            <nav class="hidden lg:block lg:sticky lg:top-24 bg-white rounded-2xl border p-5" style="border-color: var(--color-border);" aria-label="Sommaire">
                <p class="text-xs font-bold uppercase tracking-wide mb-3" style="color: var(--color-slate);">Sommaire</p>
                <ul class="space-y-2 text-sm">
                    <li><a href="#mentions-legales" class="font-medium transition-colors hover:text-orange-600" style="color: var(--color-navy);">1. Mentions légales</a></li>
                    <li><a href="#cgv" class="font-medium transition-colors hover:text-orange-600" style="color: var(--color-navy);">2. Conditions générales de vente</a></li>
                    <li><a href="#confidentialite" class="font-medium transition-colors hover:text-orange-600" style="color: var(--color-navy);">3. Politique de confidentialité</a></li>
                </ul>
            </nav>

            <div class="lg:col-span-3 space-y-8">

                {{-- ===== 1. MENTIONS LÉGALES ===== --}}
                <section id="mentions-legales" class="scroll-mt-28 bg-white rounded-2xl border p-6 sm:p-8" style="border-color: var(--color-border);">
                    <h2 class="text-2xl font-bold tracking-tight mb-6" style="color: var(--color-navy);">1. Mentions légales</h2>

                    <div class="space-y-5 text-sm leading-relaxed" style="color: var(--color-slate);">
                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">Éditeur du site</h3>
                            <p>
                                <strong>Havre de Paix</strong> — Résidence-Hôtel<br>
                                Assinie Kilomètre 18,75, Côte d'Ivoire<br>
                                Email : <a href="mailto:contact@havredepaix-assinie.com" class="underline" style="color: var(--color-blue);">contact@havredepaix-assinie.com</a><br>
                                Téléphone : +225 XX XX XX XX XX <span class="badge-orange ml-1">À compléter</span><br>
                                RCCM : <span class="badge-orange">À compléter</span><br>
                                Directeur de la publication : <span class="badge-orange">À compléter</span>
                            </p>
                        </div>
                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">Hébergement</h3>
                            <p>
                                Le site est hébergé sur un serveur privé virtuel (VPS) <span class="badge-orange">Hébergeur à compléter</span>,
                                avec diffusion de contenu via Cloudflare, Inc., 101 Townsend St, San Francisco, CA 94107, États-Unis.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">Propriété intellectuelle</h3>
                            <p>
                                L'ensemble des contenus de ce site (textes, photographies, logo, charte graphique) est la propriété exclusive
                                du Havre de Paix, sauf mention contraire. Toute reproduction, représentation ou diffusion, totale ou partielle,
                                sans autorisation écrite préalable est interdite.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- ===== 2. CGV ===== --}}
                <section id="cgv" class="scroll-mt-28 bg-white rounded-2xl border p-6 sm:p-8" style="border-color: var(--color-border);">
                    <h2 class="text-2xl font-bold tracking-tight mb-6" style="color: var(--color-navy);">2. Conditions générales de vente</h2>

                    <div class="space-y-6 text-sm leading-relaxed" style="color: var(--color-slate);">
                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.1 Objet et acceptation</h3>
                            <p>
                                Les présentes conditions générales de vente régissent les réservations d'hébergement effectuées sur le site
                                du Havre de Paix. Toute réservation implique l'acceptation pleine et entière des présentes CGV, matérialisée
                                par la case à cocher lors de la confirmation de la réservation.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.2 Prix</h3>
                            <p>
                                Les prix sont exprimés en <strong>francs CFA (FCFA)</strong>, par chambre et par nuit. Le prix total du séjour
                                (nombre de nuits × tarif applicable, ajusté le cas échéant par les tarifs saisonniers en vigueur) est affiché
                                avant la confirmation de la réservation. Le prix confirmé dans l'email de réservation est ferme et définitif.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.3 Réservation et confirmation</h3>
                            <p>
                                La réservation s'effectue en ligne en trois étapes : choix du séjour, saisie des coordonnées, confirmation.
                                Elle est confirmée instantanément par email, avec un numéro de référence unique au format
                                <strong>HDP-AAAA-XXXX</strong>. Le client s'engage à fournir des informations exactes ; l'établissement se
                                réserve le droit d'annuler une réservation manifestement erronée ou frauduleuse.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.4 Paiement — à l'arrivée uniquement</h3>
                            <p>
                                <strong>Aucun paiement en ligne n'est demandé.</strong> Le règlement du séjour s'effectue intégralement à
                                l'arrivée, à la réception de l'établissement (espèces, mobile money ou carte bancaire, selon les moyens
                                disponibles à la réception). Aucune empreinte bancaire n'est prise à la réservation.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.5 Annulation et non-présentation</h3>
                            <p>
                                L'annulation est <strong>gratuite jusqu'à 48 heures avant l'arrivée prévue</strong>, via le lien d'annulation
                                présent dans l'email de confirmation ou en contactant la réception. Toute annulation à moins de 48 heures de
                                l'arrivée, ainsi que toute non-présentation, entraîne la facturation d'une nuit de séjour.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.6 Modification</h3>
                            <p>
                                Toute demande de modification (dates, chambre, nombre de voyageurs) doit être adressée à la réception par
                                email ou téléphone et reste soumise à disponibilité. La modification peut entraîner un ajustement du prix
                                selon les tarifs en vigueur aux nouvelles dates.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.7 Arrivée, départ et occupation</h3>
                            <p>
                                Les chambres sont disponibles à partir de 14 h 00 le jour d'arrivée et doivent être libérées avant 12 h 00 le
                                jour du départ <span class="badge-orange">Horaires à confirmer</span>. Le nombre d'occupants ne peut excéder la
                                capacité maximale indiquée sur la fiche de la chambre réservée.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.8 Responsabilité et règlement intérieur</h3>
                            <p>
                                Le client s'engage à respecter le règlement intérieur de l'établissement et à faire un usage paisible des
                                lieux. L'établissement décline toute responsabilité en cas de perte ou de vol d'effets personnels non déposés
                                au coffre. Toute dégradation constatée sera facturée au client.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">2.9 Droit applicable et litiges</h3>
                            <p>
                                Les présentes CGV sont soumises au <strong>droit ivoirien</strong>. En cas de litige, les parties s'engagent à
                                rechercher une solution amiable avant toute action judiciaire. À défaut d'accord, les tribunaux compétents
                                d'Abidjan seront seuls saisis.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- ===== 3. CONFIDENTIALITÉ ===== --}}
                <section id="confidentialite" class="scroll-mt-28 bg-white rounded-2xl border p-6 sm:p-8" style="border-color: var(--color-border);">
                    <h2 class="text-2xl font-bold tracking-tight mb-6" style="color: var(--color-navy);">3. Politique de confidentialité</h2>

                    <div class="space-y-6 text-sm leading-relaxed" style="color: var(--color-slate);">
                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">3.1 Données collectées</h3>
                            <p>
                                Dans le cadre d'une réservation, nous collectons : nom complet, adresse email, numéro de téléphone et,
                                le cas échéant, vos demandes spéciales. Le formulaire de contact collecte votre nom, votre email et votre message.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">3.2 Finalités</h3>
                            <p>
                                Ces données servent exclusivement à la gestion de votre réservation : confirmation par email, rappel avant
                                votre arrivée, gestion des annulations et communication liée à votre séjour. Elles ne sont ni vendues,
                                ni cédées à des tiers à des fins commerciales.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">3.3 Destinataires et sous-traitants</h3>
                            <p>
                                Les données sont accessibles au personnel habilité de l'établissement. L'envoi des emails transactionnels
                                est assuré par la plateforme <strong>Brevo</strong> (Sendinblue SAS, France), agissant en qualité de
                                sous-traitant. Les données sont hébergées sur le serveur du site.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">3.4 Durée de conservation</h3>
                            <p>
                                Les données de réservation sont conservées pendant la durée nécessaire à la gestion du séjour et aux
                                obligations comptables et fiscales de l'établissement, puis supprimées ou anonymisées.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">3.5 Vos droits</h3>
                            <p>
                                Conformément à la <strong>loi ivoirienne n° 2013-450 du 19 juin 2013</strong> relative à la protection des
                                données à caractère personnel (autorité de contrôle : ARTCI), vous disposez d'un droit d'accès, de
                                rectification, d'opposition et de suppression de vos données. Pour l'exercer, écrivez-nous à
                                <a href="mailto:contact@havredepaix-assinie.com" class="underline" style="color: var(--color-blue);">contact@havredepaix-assinie.com</a>.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">3.6 Cookies</h3>
                            <p>
                                Le site utilise uniquement un cookie de session technique, indispensable au fonctionnement du site
                                (sécurité des formulaires). Aucun cookie publicitaire ou de suivi n'est déposé.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- CTA retour --}}
                <div class="text-center pt-4">
                    <a href="{{ route('rooms.index') }}" class="btn-primary">Voir nos chambres</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
