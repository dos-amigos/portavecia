# Roadmap: Porta Vecia

## Overview

Build a bilingual (IT/EN) multi-page website for Porta Vecia enoteca using Kirby CMS 5, progressing from infrastructure and global layout through all content pages, then engagement features (gallery, events), and finishing with SEO optimization and performance polish. The site presents a unique fusion of Italian wine bar and authentic homemade Chinese cuisine in the historic center of Este.

## Phases

**Phase Numbering:**
- Integer phases (1, 2, 3): Planned milestone work
- Decimal phases (2.1, 2.2): Urgent insertions (marked with INSERTED)

Decimal phases appear between their surrounding integers in numeric order.

- [ ] **Phase 1: Foundation and Global Layout** - Kirby 5 multilingual setup, Vite/Tailwind pipeline, header/footer/nav, language switch, responsive base, cookie consent
- [ ] **Phase 2: Core Pages** - Homepage, Chi Siamo, Menu, Vini, and Contatti pages with full content models, templates, and bilingual content
- [ ] **Phase 3: Engagement Features** - Photo gallery with lightbox/categories and events page with management
- [ ] **Phase 4: SEO and Performance** - Meta tags, structured data, hreflang, image optimization, lazy loading

## Phase Details

### Phase 1: Foundation and Global Layout
**Goal**: A working Kirby 5 site with bilingual routing, build pipeline, and the global shell (header, footer, navigation, language switch) visible on every page
**Depends on**: Nothing (first phase)
**Requirements**: INFRA-01, INFRA-02, INFRA-03, INFRA-04, INFRA-05, LANG-02, LANG-03
**Success Criteria** (what must be TRUE):
  1. Visiting the site shows a responsive page with sticky header (logo, navigation links, language switch) and footer (address, hours, social) on both mobile and desktop
  2. Clicking the language switch toggles between Italian and English versions, and all UI strings (navigation labels, footer text, button labels) appear in the selected language
  3. The Vite dev server runs with HMR and `npm run build` produces production assets without errors
  4. Cookie consent con blocco preventivo conforme Garante Privacy 2021: banner con bottoni equiparati (Accetta/Rifiuta/Personalizza), GA4 e Google Maps bloccati prima del consenso, consenso granulare per categoria, click-to-load per mappe embedded
  5. Content files use Kirby multilingual structure (`.it.txt` / `.en.txt`) from the first commit
**Plans**: 3 plans
Plans:
- [x] 01-01-PLAN.md -- Kirby 5 scaffolding + multilingual IT/EN + Vite/Tailwind/Alpine pipeline
- [x] 01-02-PLAN.md -- Global layout: header, footer, nav, language switch, responsive Candore styling
- [ ] 01-03-PLAN.md -- Cookie consent system (Garante Privacy 2021 compliant)
**UI hint**: yes

### Phase 2: Core Pages
**Goal**: Visitors can browse all primary content pages -- Homepage, Chi Siamo, Menu, Vini, and Contatti -- with full bilingual content, and the bar owner can edit everything from Kirby Panel
**Depends on**: Phase 1
**Requirements**: HOME-01, HOME-02, HOME-03, HOME-04, ABOUT-01, ABOUT-02, MENU-01, MENU-02, MENU-03, WINE-01, WINE-02, WINE-03, CONT-01, CONT-02, CONT-03, CONT-04, LANG-01
**Success Criteria** (what must be TRUE):
  1. Homepage displays a hero with strong imagery and WhatsApp CTA, a fusion concept teaser section, featured wines/dishes previews linking to their pages, and an "L'Esperienza" storytelling section
  2. Menu page lists dishes organized by category with name, description, and price in HTML (not PDF), with wine pairing suggestions on main dishes, and the owner can add/remove/edit dishes from Kirby Panel
  3. Wine page shows a curated selection with bottle photo, name, origin, tasting notes, price, and food pairing suggestions, all editable from Panel
  4. Contact page shows an embedded map, clearly visible opening hours, one-tap WhatsApp and phone buttons, and full address with directions
  5. About page presents the story, philosophy, interior/plateatico photos, and the "Due Tradizioni, Un Tavolo" fusion concept
**Plans**: TBD
**UI hint**: yes

### Phase 3: Engagement Features
**Goal**: Visitors can explore a photo gallery of the venue, food, and atmosphere, and discover upcoming events, degustazioni, and special evenings
**Depends on**: Phase 2
**Requirements**: GALL-01, GALL-02, GALL-03, EVNT-01, EVNT-02, EVNT-03
**Success Criteria** (what must be TRUE):
  1. Gallery page displays photos in a grid with lightbox viewing, and photos can be filtered by category (locale, piatti, vini, eventi)
  2. Events page lists upcoming special evenings and degustazioni, each with date, description, and image
  3. The bar owner can add, remove, and reorder gallery photos and manage events entirely from Kirby Panel
**Plans**: TBD
**UI hint**: yes

### Phase 4: SEO and Performance
**Goal**: The site is discoverable in local search results, loads fast on mobile, and has proper technical SEO for both language versions
**Depends on**: Phase 3
**Requirements**: SEO-01, SEO-02, SEO-03, SEO-04
**Success Criteria** (what must be TRUE):
  1. Every page has a unique meta title and description (editable from Panel) and correct hreflang tags pointing to its Italian/English counterpart
  2. JSON-LD structured data (LocalBusiness/Restaurant with servesCuisine for both Italian wine and Chinese food) is present on key pages and validates in Google Rich Results Test
  3. Images use srcset with multiple sizes, WebP format where supported, and lazy loading -- gallery and menu pages load under 3 seconds on a 4G connection
**Plans**: TBD

## Progress

**Execution Order:**
Phases execute in numeric order: 1 -> 2 -> 3 -> 4

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. Foundation and Global Layout | 0/3 | Not started | - |
| 2. Core Pages | 0/TBD | Not started | - |
| 3. Engagement Features | 0/TBD | Not started | - |
| 4. SEO and Performance | 0/TBD | Not started | - |
