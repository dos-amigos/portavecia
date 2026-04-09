# Phase 3: Engagement Features - Discussion Log

> **Audit trail only.** Do not use as input to planning, research, or execution agents.
> Decisions are captured in CONTEXT.md — this log preserves the alternatives considered.

**Date:** 2026-04-09
**Phase:** 03-engagement-features
**Areas discussed:** Layout galleria e filtri, Lightbox e navigazione foto, Design pagina eventi, Contenuto e foto da usare

---

## Layout galleria e filtri

| Option | Description | Selected |
|--------|-------------|----------|
| Masonry (Pinterest-style) | Foto di altezze diverse che si incastrano — più dinamico e moderno | ✓ |
| Griglia regolare | Tutte le foto della stessa dimensione ritagliate — più ordinato | |
| Claude decide | Scegli tu l'approccio migliore | |

**User's choice:** Masonry (Pinterest-style)

| Option | Description | Selected |
|--------|-------------|----------|
| Bottoni/tabs orizzontali | Bottoni "Tutto Locale Piatti Vini Eventi" sopra la griglia | ✓ |
| Dropdown/select | Menu a tendina compatto | |
| Claude decide | Scegli tu il formato migliore | |

**User's choice:** Bottoni/tabs orizzontali

| Option | Description | Selected |
|--------|-------------|----------|
| Fade + riposizionamento | Le foto scompaiono con fade, la griglia si ricompone fluidamente | ✓ |
| Nessuna animazione | Cambio istantaneo | |
| Claude decide | Scegli tu l'effetto migliore | |

**User's choice:** Fade + riposizionamento

---

## Lightbox e navigazione foto

| Option | Description | Selected |
|--------|-------------|----------|
| Swipe touch su mobile | Scorrere le foto con il dito | ✓ |
| Frecce navigazione | Frecce sinistra/destra | ✓ |
| Contatore foto | Indicatore "3 / 12" | ✓ |
| Didascalia sotto la foto | Titolo o descrizione sotto ogni foto | ✓ |

**User's choice:** Tutte le opzioni selezionate — lightbox completo

---

## Design pagina eventi

| Option | Description | Selected |
|--------|-------------|----------|
| Cards con immagine | Card per ogni evento con foto grande, titolo, data, descrizione | ✓ |
| Timeline verticale | Lista cronologica con linea verticale e punti | |
| Claude decide | Scegli tu il formato migliore | |

**User's choice:** Cards con immagine

| Option | Description | Selected |
|--------|-------------|----------|
| Solo futuri | Mostra solo eventi con data futura | |
| Separati | Sezione "Prossimi Eventi" sopra + "Eventi Passati" sotto in grigio | ✓ |
| Claude decide | Scegli tu l'approccio migliore | |

**User's choice:** Separati (futuri + passati)

---

## Contenuto e foto da usare

| Option | Description | Selected |
|--------|-------------|----------|
| Usa tutte con categorie auto | Claude assegna categorie a tutte le 17 foto | ✓ |
| Solo alcune foto | Utente sceglie quali foto | |
| Claude decide | Usa tutte le foto e assegna categorie | |

**User's choice:** Usa tutte con categorie auto

| Option | Description | Selected |
|--------|-------------|----------|
| 3-4 eventi | Mix di degustazioni, serate a tema, aperitivi speciali | ✓ |
| 1-2 eventi | Il minimo per testare | |
| Claude decide | Scegli tu quanti ne servono | |

**User's choice:** 3-4 eventi

---

## Claude's Discretion

- Masonry implementation approach (CSS columns vs JS)
- GLightbox configuration details
- Event card layout specifics
- Animation timing and easing
- Responsive breakpoints for gallery grid

## Deferred Ideas

- Video gallery integration (ADV-01)
- Google Reviews (ADV-03)
- Event booking beyond WhatsApp
