---
phase: 02-core-pages
plan: 04
subsystem: about-contact-pages
tags: [about, contact, openstreetmap, leaflet, storytelling, bilingual]
dependency_graph:
  requires: [01-02]
  provides: [about-page, contact-page, contact-map]
  affects: [site-navigation]
tech_stack:
  added: [leaflet-1.9.4, openstreetmap-de-tiles]
  patterns: [alternating-blocks, split-layout, gdpr-safe-map]
key_files:
  created:
    - site/blueprints/pages/about.yml
    - site/templates/about.php
    - site/snippets/sections/about-block.php
    - site/blueprints/pages/contact.yml
    - site/templates/contact.php
    - site/snippets/sections/contact-map.php
    - content/2_about/about.it.txt
    - content/2_about/about.en.txt
    - content/5_contact/contact.it.txt
    - content/5_contact/contact.en.txt
  modified:
    - site/languages/it.php
    - site/languages/en.php
decisions:
  - Used Leaflet with openstreetmap.de tiles for GDPR-safe map (no consent needed)
  - Contact info (phone, whatsapp, hours) sourced from global site controller, not duplicated in contact blueprint
  - Content files created but gitignored per project convention (Panel-managed in production)
metrics:
  duration: 2m30s
  completed: 2026-04-09T10:16:41Z
---

# Phase 02 Plan 04: About and Contact Pages Summary

About page with 4 alternating storytelling blocks (story, place, fusion concept, atmosphere) and Contact page with Leaflet OpenStreetMap (GDPR-safe), opening hours, one-tap WhatsApp/phone buttons, and Google Maps directions link.

## What Was Built

### About Page (Chi Siamo)
- **Blueprint** (`site/blueprints/pages/about.yml`): Tabbed layout with content, story, place, fusion, atmosphere, and images tabs. Each storytelling tab has title, text, and image fields.
- **Template** (`site/templates/about.php`): Page header with headline/intro, then iterates 4 storytelling blocks with alternating layout (even blocks: text left/image right, odd blocks: image left/text right).
- **Snippet** (`site/snippets/sections/about-block.php`): Reusable alternating block with `md:order-1`/`md:order-2` CSS classes for layout reversal. Renders title, kirbytext content, and responsive image with lazy loading.
- **Content**: Bilingual IT/EN content covering the enoteca's origin story, the venue description, the "Due Tradizioni, Un Tavolo" fusion concept (ABOUT-02), and the atmosphere/experience.

### Contact Page (Contatti)
- **Blueprint** (`site/blueprints/pages/contact.yml`): Fields for headline, intro, map coordinates (lat/lng), map popup text, and Google Maps directions URL. Map fields marked `translate: false`.
- **Template** (`site/templates/contact.php`): Split layout (map left, info right on desktop, stacked on mobile). Displays address with directions button, opening hours from global site data, one-tap phone and WhatsApp buttons (CONT-03), and email link.
- **Map Snippet** (`site/snippets/sections/contact-map.php`): Leaflet.js 1.9.4 with openstreetmap.de tiles (GDPR-safe German-hosted tile server). Renders interactive map with marker and popup. Loads CSS/JS from unpkg CDN.
- **Content**: Bilingual IT/EN with Este center coordinates (45.2272, 11.6574) and Google Maps directions link.

### Translation Keys Added
- `contact.address`, `contact.directions`, `contact.call` in both IT and EN language files.

## Commits

| Task | Commit | Description |
|------|--------|-------------|
| 1 | 97dc9eb | About page: blueprint, template, snippet |
| 2 | d9b2ea9 | Contact page: blueprint, template, map snippet, translations |

## Deviations from Plan

### Auto-fixed Issues

**1. [Rule 3 - Blocking] Added missing translation keys for contact template**
- **Found during:** Task 2
- **Issue:** Contact template uses `t('contact.address')`, `t('contact.directions')`, `t('contact.call')` but these keys did not exist in language files
- **Fix:** Added 3 translation keys to both `site/languages/it.php` and `site/languages/en.php`
- **Files modified:** `site/languages/it.php`, `site/languages/en.php`
- **Commit:** d9b2ea9

## Known Stubs

Content files in `content/2_about/` and `content/5_contact/` contain placeholder text that will need to be replaced with actual client-provided copy. Images are referenced in blueprints but no actual image files are included (will be uploaded via Panel by the client). This is intentional -- content is managed via Kirby Panel in production.

## Self-Check: PASSED
