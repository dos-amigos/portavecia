# Phase 2: Core Pages - Context

**Gathered:** 2026-04-09
**Status:** Ready for planning

<domain>
## Phase Boundary

Build the 5 core content pages — Homepage, Chi Siamo, Menu/Cucina, Vini, Contatti — with full bilingual IT/EN content, Kirby blueprints for Panel editing, and responsive Candore-inspired styling. Each page uses the global layout (header/footer) from Phase 1. All visible text must use Kirby's `t()` system or content field methods for bilingual support.

</domain>

<decisions>
## Implementation Decisions

### Homepage
- **D-01:** Hero section uses **video background** — the `preparazione-spaghetti-di-riso.mp4` from `_sources/` as primary, supplemented with free stock video from Pexels or similar (theme: Asian/Chinese cooking, stir-fried noodles, wok). Autoplay muted loop with text overlay and WhatsApp CTA button.
- **D-02:** Section order below hero: **Claude decides** optimal arrangement of fusion concept teaser, wine/dish previews, and "L'Esperienza" storytelling section — optimize for engagement and conversion.
- **D-03:** WhatsApp CTA appears in **both** hero section AND as a **floating button** (bottom-right, chat-widget style) visible on ALL pages site-wide. Floating button should be unobtrusive but always accessible.
- **D-04:** Integrate **free stock videos** from internet (Pexels, Pixabay, etc.) throughout homepage sections to enrich the visual experience — theme: cooking, wine, Asian cuisine, elegant dining.

### Menu / Cucina
- **D-05:** Dishes displayed as **cards with photos** — each dish has its own card with photo, name, description, and price. Use real photos from `_sources/` (menu-food.jpeg, Ravioli cinesi.jpeg, Spaghetti di riso con verdure e gamberi.jpeg, etc.). Dishes organized by category.
- **D-06:** Wine pairing suggestions on main dishes: **Claude decides** the best presentation format (inline text, badge, separate section, etc.).

### Vini
- **D-07:** Wine selection displayed as **vertical elegant list** — bottle photo on the left, name/origin/tasting notes/price/food pairing on the right. Style inspired by Candore wine page. One wine per row, generous spacing.

### Contatti
- **D-08:** Map uses **OpenStreetMap (Leaflet)** embedded directly — zero GDPR issues, loads without cookie consent. A separate **"Indicazioni" button** opens Google Maps in a new tab with the venue coordinates. No Google Maps iframe on the site.
- **D-09:** **Split layout** — map on the left, contact info (hours, phone, WhatsApp, address) on the right. Stacks vertically on mobile.

### Chi Siamo
- **D-10:** **Alternating storytelling blocks** — text and image alternate sides (image left/right) telling: the story → the place → the fusion philosophy ("Due Tradizioni, Un Tavolo") → the atmosphere. Uses the 4 sala-interna photos and cucina-preparazione-ingredienti.jpeg from `_sources/`. Style inspired by Candore features page.

### Content & Bilingual
- **D-11:** All page content uses **realistic placeholder text** written by Claude in both Italian and English. Texts should sound authentic and match the venue's character — an intimate wine bar in the historic center of Este with authentic homemade Chinese cuisine. The client will review and adjust.
- **D-12:** All content editable from Kirby Panel — blueprints must define structured fields for every editable element (hero text, dish cards, wine entries, contact info, about sections).

### Claude's Discretion
- Homepage section ordering (D-02) — optimize for engagement
- Wine pairing format on menu cards (D-06)
- Specific video stock selections — find high-quality free videos that match the aesthetic
- Animation/transition choices for sections (keep elegant and subtle per project constraints)
- Responsive breakpoints and mobile adaptations for each page layout

</decisions>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

### Phase 1 Outputs (foundation to build on)
- `site/snippets/layout/header.php` — Global header with nav, language switch, mobile menu
- `site/snippets/layout/footer.php` — Global footer with contacts, hours, social, cookie banner
- `site/controllers/site.php` — Global data provider (phone, whatsapp, email, address, hours, social)
- `site/languages/it.php` — Italian translations (add new keys for Phase 2 pages)
- `site/languages/en.php` — English translations (add new keys for Phase 2 pages)
- `site/blueprints/site.yml` — Global site fields (phone, whatsapp, hours, social, ga4MeasurementId)
- `src/css/main.css` — Tailwind CSS 4 theme tokens (@theme with --color-primary, --font-heading, etc.) and component classes (.btn-primary, .btn-outline, .section-padding, .container-site)
- `src/js/main.js` — Alpine.js entry point

### Design Reference
- Candore template: `https://duruthemes.com/demo/html/candore/demo1/` — menubook4.html (menu), wine.html (vini), features.html (chi siamo), contact.html (contatti)

### Asset Sources
- `_sources/` — Client photos and video (17 photos + 1 video) to use for real content

### Project Context
- `.planning/PROJECT.md` — Core value, requirements, constraints
- `.planning/REQUIREMENTS.md` — Requirement IDs HOME-01 through CONT-04 plus LANG-01

</canonical_refs>

<code_context>
## Existing Code Insights

### Reusable Assets
- `site/controllers/site.php` — Already provides $phone, $whatsapp, $email, $address, $hours, $social to all templates
- `site/snippets/components/language-switch.php` — Bilingual switch pattern to replicate
- `src/css/main.css` — .btn-primary, .btn-outline, .section-padding, .container-site ready to use
- Alpine.js already initialized — use for interactive elements (mobile menu pattern established)

### Established Patterns
- Templates include `snippet('layout/header')` and `snippet('layout/footer')`
- All UI strings use `t('key')` — new pages must follow this pattern
- Kirby blueprints in `site/blueprints/pages/` define Panel editing fields
- Content files in `content/` use `.it.txt` / `.en.txt` for bilingual (gitignored, created locally)
- Vite builds from `src/js/main.js` entry, CSS via `src/css/main.css`

### Integration Points
- New page templates go in `site/templates/`
- New page blueprints go in `site/blueprints/pages/`
- New snippets go in `site/snippets/` (organized by purpose: layout/, components/)
- New translation keys added to both `site/languages/it.php` and `site/languages/en.php`
- Content structure directories created in `content/` for local dev

</code_context>

<specifics>
## Specific Ideas

- Use the real video `_sources/preparazione-spaghetti-di-riso.mp4` as homepage hero background
- Search Pexels/Pixabay for free stock videos: stir-fried noodles in wok, wine pouring, elegant dining atmosphere
- Photos from `_sources/` to use: sala-interna (4 variants) for Chi Siamo, menu-food/Ravioli/Spaghetti for Menu cards, piatto-pesce/Polpetta/Zuppa wonton for additional dishes
- OpenStreetMap via Leaflet.js for contact page map — lightweight, no GDPR concerns
- WhatsApp floating button should use the WhatsApp green color and be recognizable instantly
- Porta Vecia coordinates for map and "Indicazioni" link: Este (PD), historic center

</specifics>

<deferred>
## Deferred Ideas

- Video atmosferico professionale per hero (ADV-01 in v2 requirements)
- Sezione "Piatto del momento" in homepage (ADV-02 in v2)
- Google Reviews curate (ADV-03 in v2)

</deferred>

---

*Phase: 02-core-pages*
*Context gathered: 2026-04-09*
