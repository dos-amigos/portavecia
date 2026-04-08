# Requirements: Porta Vecia

**Defined:** 2026-04-08
**Core Value:** Invitare i visitatori a scoprire Porta Vecia come esperienza unica: l'incontro tra enoteca italiana e cucina cinese autentica in un contesto storico suggestivo.

## v1 Requirements

Requirements for initial release. Each maps to roadmap phases.

### Infrastruttura

- [ ] **INFRA-01**: Installazione Kirby 5 con multilingual IT/EN attivato dal primo commit
- [ ] **INFRA-02**: Pipeline Vite 8 + Tailwind CSS 4 + Alpine.js configurata e funzionante
- [ ] **INFRA-03**: Layout globale con header sticky (logo, nav, language switch) e footer (contatti, orari, social)
- [ ] **INFRA-04**: Design responsive mobile-first ispirato a Candore
- [ ] **INFRA-05**: Cookie consent banner GDPR compliant

### Homepage

- [ ] **HOME-01**: Hero section con immagine forte del locale/piatti e CTA prenotazione WhatsApp
- [ ] **HOME-02**: Sezione teaser "fusion concept" — anteprima dell'incontro vino+cucina cinese
- [ ] **HOME-03**: Anteprima vini e piatti in evidenza con link alle rispettive pagine
- [ ] **HOME-04**: Sezione "L'Esperienza" — storytelling visivo dell'esperienza al locale

### Chi Siamo

- [ ] **ABOUT-01**: Pagina con storia del locale, filosofia, foto interni/plateatico
- [ ] **ABOUT-02**: Sezione dedicata al concept fusion "Due Tradizioni, Un Tavolo"

### Menu / Cucina

- [ ] **MENU-01**: Pagina menu HTML nativo con categorie, nome piatto, descrizione, prezzo (stile Candore menubook)
- [ ] **MENU-02**: Suggerimenti abbinamento vino per i piatti principali
- [ ] **MENU-03**: Tutto editabile da Kirby Panel (aggiungere/rimuovere/modificare piatti)

### Vini

- [ ] **WINE-01**: Vetrina selezione vini con foto bottiglia, nome, origine, note degustazione, prezzo (stile Candore wine)
- [ ] **WINE-02**: Suggerimenti abbinamento cibo per ciascun vino
- [ ] **WINE-03**: Tutto editabile da Kirby Panel

### Gallery

- [ ] **GALL-01**: Galleria fotografica con lightbox (stile Candore gallery)
- [ ] **GALL-02**: Foto organizzabili per categoria (locale, piatti, vini, eventi)
- [ ] **GALL-03**: Gestibile da Kirby Panel

### Eventi

- [ ] **EVNT-01**: Pagina eventi con lista serate speciali, degustazioni, eventi stagionali
- [ ] **EVNT-02**: Ogni evento con data, descrizione, immagine
- [ ] **EVNT-03**: Gestibile da Kirby Panel

### Dove Trovarci / Contatti

- [ ] **CONT-01**: Mappa embedded (Google Maps o OpenStreetMap)
- [ ] **CONT-02**: Orari di apertura ben visibili e editabili da backend
- [ ] **CONT-03**: Bottoni WhatsApp e telefono one-tap
- [ ] **CONT-04**: Indirizzo completo con indicazioni

### SEO e Performance

- [ ] **SEO-01**: Meta title/description per ogni pagina, editabili da backend
- [ ] **SEO-02**: JSON-LD structured data (LocalBusiness/Restaurant)
- [ ] **SEO-03**: Tag hreflang per versioni IT/EN
- [ ] **SEO-04**: Ottimizzazione immagini con srcset e lazy loading

### Bilingue

- [ ] **LANG-01**: Tutti i contenuti disponibili in italiano e inglese
- [ ] **LANG-02**: Language switch visibile in header
- [ ] **LANG-03**: Stringhe UI tradotte tramite sistema t() di Kirby

## v2 Requirements

Deferred to future release. Tracked but not in current roadmap.

### Contenuti Avanzati

- **ADV-01**: Video atmosferico autoplay nel hero (richiede footage professionale)
- **ADV-02**: Sezione "Highlight stagionale / Piatto del momento" in homepage
- **ADV-03**: Citazioni Google Reviews curate in homepage
- **ADV-04**: Schema.org avanzato (FAQ, Event schema)

## Out of Scope

Explicitly excluded. Documented to prevent scope creep.

| Feature | Reason |
|---------|--------|
| E-commerce / vendita online vini | Il focus è portare gente al locale, non spedire bottiglie |
| Form di prenotazione integrato | WhatsApp/telefono più diretto e personale per enoteca intima |
| Catalogo vini completo con filtri | Vetrina curata è più adatta; catalogo troppo oneroso da mantenere |
| Blog / news | Non necessario per v1; eventi e social bastano per aggiornamenti |
| Account utente / programma fedeltà | Complessità eccessiva per singola location, loyalty gestita in persona |
| Sistema recensioni integrato | Piattaforme esterne (Google, TripAdvisor) più credibili |
| Menu PDF scaricabile | Anti-pattern SEO/UX; menu HTML nativo è superiore |
| Chatbot / AI recommendation | Inappropriato per la scala e il calore del locale |
| Supporto multi-location | Singola location, non over-engineerare |
| Animazioni complesse / parallax eccessivo | Performance > effetti; eleganza sobria come Candore |

## Traceability

Which phases cover which requirements. Updated during roadmap creation.

| Requirement | Phase | Status |
|-------------|-------|--------|
| INFRA-01 | TBD | Pending |
| INFRA-02 | TBD | Pending |
| INFRA-03 | TBD | Pending |
| INFRA-04 | TBD | Pending |
| INFRA-05 | TBD | Pending |
| HOME-01 | TBD | Pending |
| HOME-02 | TBD | Pending |
| HOME-03 | TBD | Pending |
| HOME-04 | TBD | Pending |
| ABOUT-01 | TBD | Pending |
| ABOUT-02 | TBD | Pending |
| MENU-01 | TBD | Pending |
| MENU-02 | TBD | Pending |
| MENU-03 | TBD | Pending |
| WINE-01 | TBD | Pending |
| WINE-02 | TBD | Pending |
| WINE-03 | TBD | Pending |
| GALL-01 | TBD | Pending |
| GALL-02 | TBD | Pending |
| GALL-03 | TBD | Pending |
| EVNT-01 | TBD | Pending |
| EVNT-02 | TBD | Pending |
| EVNT-03 | TBD | Pending |
| CONT-01 | TBD | Pending |
| CONT-02 | TBD | Pending |
| CONT-03 | TBD | Pending |
| CONT-04 | TBD | Pending |
| SEO-01 | TBD | Pending |
| SEO-02 | TBD | Pending |
| SEO-03 | TBD | Pending |
| SEO-04 | TBD | Pending |
| LANG-01 | TBD | Pending |
| LANG-02 | TBD | Pending |
| LANG-03 | TBD | Pending |

**Coverage:**
- v1 requirements: 34 total
- Mapped to phases: 0
- Unmapped: 34 ⚠️

---
*Requirements defined: 2026-04-08*
*Last updated: 2026-04-08 after initial definition*
