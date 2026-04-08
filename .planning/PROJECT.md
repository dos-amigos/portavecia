# Porta Vecia

## What This Is

Sito web multi-pagina per l'enoteca "Porta Vecia" di Este (PD), costruito con Kirby CMS. Il sito presenta un'enoteca nel centro storico di Este che offre vini di qualità e autentica cucina cinese fatta in casa — ravioli, involtini, spaghetti e altre prelibatezze preparate al momento, servite come accompagnamento all'aperitivo e per cena. Il sito è bilingue (italiano/inglese) e interamente gestibile da backend.

## Core Value

Invitare i visitatori a scoprire Porta Vecia come esperienza unica: l'incontro tra enoteca italiana e cucina cinese autentica in un contesto storico suggestivo, con un forte invito all'aperitivo accompagnato da prelibatezze fatte in casa.

## Requirements

### Validated

(None yet — ship to validate)

### Active

- [ ] Homepage con hero, intro locale, anteprima vini/piatti, CTA prenotazione
- [ ] Pagina "Chi Siamo" con storia, filosofia, foto interni/esterni, plateatico e atmosfera intima
- [ ] Pagina "Menu/Cucina" con piatti cinesi fatti in casa, foto e descrizioni (stile menubook Candore)
- [ ] Pagina "Vini" con vetrina selezione in evidenza, foto e note (stile wine page Candore)
- [ ] Pagina "Gallery" con galleria fotografica del locale, piatti, atmosfera (stile gallery Candore)
- [ ] Pagina "Dove Trovarci / Contatti" con mappa, orari, telefono, WhatsApp (stile contact Candore)
- [ ] Pagina "Eventi" per serate speciali, degustazioni, eventi stagionali
- [ ] Concept creativo per promuovere l'aperitivo con cucina cinese (da definire in fase di ricerca)
- [ ] Navigazione con header fisso e footer con contatti rapidi
- [ ] Prenotazioni via WhatsApp e telefono (bottoni diretti, niente form)
- [ ] Tutti i contenuti editabili da backend Kirby (testi, foto, orari, menu, vini, eventi)
- [ ] Sito bilingue italiano/inglese con switch lingua
- [ ] Design responsive, stile elegante ispirato al template Candore
- [ ] SEO base e meta tag per visibilità locale

### Out of Scope

- E-commerce / vendita online vini — non richiesto, il focus è portare gente al locale
- Form di prenotazione integrato — gestione via WhatsApp/telefono, più diretto e personale
- Blog / sezione news — non necessario per v1
- Catalogo vini completo con filtri — solo vetrina dei vini in evidenza
- Sistema di recensioni integrato — si usano piattaforme esterne (Google, TripAdvisor)
- App mobile nativa — sito responsive è sufficiente

## Context

- **Locale**: Enoteca nel centro storico di Este (Padova), con plateatico esterno per la bella stagione e sala interna intima, ideale per coppie
- **Unicità**: Fusione tra enoteca italiana e cucina cinese autentica fatta in casa — ravioli, involtini, spaghetti preparati al momento
- **Posizionamento**: Aperitivo con vini di qualità + prelibatezze cinesi come accompagnamento. Anche cena.
- **Target**: Coppie, amanti del buon vino, curiosi della cucina fusion, turisti che visitano Este
- **Brand**: Logo esistente, palette colori e font da definire basandosi sullo stile elegante del template Candore
- **Template di riferimento**: https://duruthemes.com/demo/html/candore/demo1/
  - Menu: stile menubook4.html (lista con nome, prezzo, descrizione)
  - Vini: stile wine.html (griglia con foto, nome, prezzo, note degustazione)
  - Gallery: stile gallery-image.html (griglia con lightbox)
  - Features: stile features.html (blocchi numerati con immagine alternata)
  - Contatti: stile contact.html (info contatto + form semplificato → nel nostro caso bottoni WhatsApp/telefono)
- **CMS**: Kirby — file-based, no database, pannello admin per editare tutto

## Constraints

- **Tech stack**: Kirby CMS (PHP) — richiesto esplicitamente
- **Lingue**: Italiano + Inglese — predisposti dal giorno 1 con il sistema multilingua di Kirby
- **Brand**: Logo fornito dal cliente, resto dell'identità visiva da definire ispirandosi a Candore
- **Prenotazioni**: Solo WhatsApp/telefono, nessun servizio esterno o form
- **Hosting**: Da definire (ma Kirby richiede solo PHP, niente database)

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Kirby CMS | Richiesto dal cliente, file-based, semplice da gestire | — Pending |
| Multi-pagina (no one-page) | Più organizzato per i contenuti, migliore SEO, scalabile | — Pending |
| Prenotazioni WhatsApp/telefono | Più diretto e personale, niente complessità form/email | — Pending |
| Vetrina vini (no catalogo completo) | Semplicità, focus su selezione curata piuttosto che lista esaustiva | — Pending |
| Bilingue IT/EN dal giorno 1 | Este ha turismo, predisporre subito evita refactoring | — Pending |
| Stile ispirato a Candore | Reference visivo chiaro condiviso, elegante e adatto al settore | — Pending |

## Evolution

This document evolves at phase transitions and milestone boundaries.

**After each phase transition** (via `/gsd:transition`):
1. Requirements invalidated? → Move to Out of Scope with reason
2. Requirements validated? → Move to Validated with phase reference
3. New requirements emerged? → Add to Active
4. Decisions to log? → Add to Key Decisions
5. "What This Is" still accurate? → Update if drifted

**After each milestone** (via `/gsd:complete-milestone`):
1. Full review of all sections
2. Core Value check — still the right priority?
3. Audit Out of Scope — reasons still valid?
4. Update Context with current state

---
*Last updated: 2026-04-08 after initialization*
