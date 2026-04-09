# Phase 3: Engagement Features - Context

**Gathered:** 2026-04-09
**Status:** Ready for planning

<domain>
## Phase Boundary

Build the Gallery page (photo grid with category filters and lightbox viewing) and Events page (upcoming/past special evenings and degustazioni). Both pages bilingual IT/EN, fully editable from Kirby Panel.

</domain>

<decisions>
## Implementation Decisions

### Gallery Layout
- **D-01:** Photo grid uses **masonry layout** (Pinterest-style) — photos of different heights fit together dynamically. Use CSS columns or a lightweight JS masonry approach (no heavy library).
- **D-02:** Category filters as **horizontal tab buttons** above the grid — "Tutto | Locale | Piatti | Vini | Eventi". Click to filter with **fade + reposition animation** using Alpine.js transitions.
- **D-03:** All photos from `_sources/` used with auto-assigned categories:
  - **Locale:** sala-interna.jpeg, sala-interna 2.jpeg, sala-interna 3.jpeg, sala-interna 2 tavolino per 2.jpeg, sala-interna-4-tavolino per 2.jpeg
  - **Piatti:** menu-food.jpeg, menu-food_2.jpeg, Ravioli cinesi.jpeg, Spaghetti di riso con verdure e gamberi.jpeg, Pasta-wenzhounese.jpeg, piatto-pesce.jpeg, Polpetta di pesce wenzhounese.jpeg, Riso-wenzhounese.jpeg, Zuppa wonton wenzhounese.jpeg
  - **Cucina:** cucina-preparazione-ingredienti.jpeg

### Lightbox
- **D-04:** Use **GLightbox** (already in project stack) with full features:
  - Swipe touch navigation on mobile
  - Arrow navigation on desktop
  - Photo counter ("3 / 12")
  - Caption/description below each photo
- **D-05:** Lightbox should respect current filter — if viewing "Piatti", only cycle through piatti photos.

### Events Page
- **D-06:** Events displayed as **cards with image** — large photo, title, date, description. Consistent visual style with dish cards from menu page.
- **D-07:** **Separate future and past events** — "Prossimi Eventi" section on top, "Eventi Passati" section below with dimmed/faded styling. Past events auto-sort by most recent first.
- **D-08:** Create **3-4 placeholder events** — mix of wine degustazioni, themed evenings, and special aperitivo events. Realistic Italian text.
- **D-09:** Each event has: title, date, time, description, image, and optional "prenota" (WhatsApp link). Editable via Kirby Panel structure fields.

### Bilingual & Panel
- **D-10:** All gallery captions and event content bilingual IT/EN via Kirby content files.
- **D-11:** Gallery photos manageable from Panel — upload, reorder, assign category, add caption per photo.
- **D-12:** Events manageable from Panel — add/edit/remove events with all fields.

### Claude's Discretion
- Masonry implementation approach (CSS columns vs JS)
- GLightbox configuration details
- Event card layout specifics (image ratio, spacing)
- Animation timing and easing for filter transitions
- How to handle the "Vini" gallery category (may overlap with Events if wine tasting photos)
- Responsive breakpoints for gallery grid columns

</decisions>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

### Phase 2 Outputs (build on established patterns)
- `site/snippets/sections/dish-card.php` — Card component pattern to reuse for event cards
- `site/templates/wines.php` — Vertical list layout pattern
- `site/controllers/site.php` — Global data provider ($phone, $whatsapp for event CTA)
- `site/languages/it.php` — Add gallery/event translation keys
- `site/languages/en.php` — Add gallery/event translation keys
- `src/css/main.css` — Tailwind theme tokens and component classes (.btn-primary, .section-padding, etc.)
- `src/js/main.js` — Alpine.js entry point (add gallery filter logic here)

### Design Reference
- Candore template: `https://duruthemes.com/demo/html/candore/demo1/` — gallery.html (photo grid), blog.html (event cards pattern)

### Asset Sources
- `_sources/` — 17 client photos to populate gallery with real content

### Project Context
- `.planning/PROJECT.md` — Core value, requirements, constraints
- `.planning/REQUIREMENTS.md` — Requirement IDs GALL-01 through EVNT-03

</canonical_refs>

<code_context>
## Existing Code Insights

### Reusable Assets
- `site/snippets/sections/dish-card.php` — Card pattern with photo, title, description, price. Adapt for event cards.
- `site/snippets/components/whatsapp-float.php` — WhatsApp CTA pattern for event booking buttons
- `.btn-primary`, `.btn-outline`, `.section-padding`, `.container-site` — Established Tailwind component classes

### Established Patterns
- Templates include `snippet('layout/header')` and `snippet('layout/footer')`
- All UI strings use `t('key')` for bilingual support
- Kirby blueprints with structure fields for repeatable content (dishes, wines pattern)
- Content files in `content/` with `.it.txt` / `.en.txt` for bilingual
- Tailwind arbitrary values (`bg-[#hex]`, `min-h-[Npx]`) DON'T compile — use inline styles for non-theme values

### Integration Points
- New page templates: `site/templates/gallery.php`, `site/templates/events.php`
- New blueprints: `site/blueprints/pages/gallery.yml`, `site/blueprints/pages/events.yml`
- Content directories: `content/6_gallery/`, `content/7_events/` (nav already has Gallery and Events links)
- GLightbox loaded via CDN on gallery page only (same pattern as Leaflet on contact page)
- Alpine.js for filter interaction (already initialized globally)

</code_context>

<specifics>
## Specific Ideas

- Use all 17 photos from `_sources/` to populate the gallery with real content
- Events placeholder: "Degustazione Amarone", "Serata Dim Sum", "Aperitivo d'Estate", "Wine & Wonton Night"
- Gallery page header could reuse the same section-padding + centered title pattern from other pages
- Event "prenota" button links to WhatsApp with pre-filled message about the event
- Past events shown with reduced opacity or desaturated styling to visually distinguish from upcoming

</specifics>

<deferred>
## Deferred Ideas

- Video gallery integration (ADV-01: video atmosferico professionale)
- Google Reviews integration (ADV-03 in v2)
- Event booking system beyond WhatsApp

</deferred>

---

*Phase: 03-engagement-features*
*Context gathered: 2026-04-09*
