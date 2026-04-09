---
phase: 01-foundation-and-global-layout
plan: 02
subsystem: global-layout
tags: [header, footer, language-switch, responsive, candore, alpine-js]
dependency_graph:
  requires: [01-01]
  provides: [layout-header, layout-footer, language-switch, site-controller, base-styles]
  affects: [all-templates, all-pages]
tech_stack:
  added: [alpine-js-mobile-menu, tailwind-layer-base, tailwind-layer-components]
  patterns: [kirby-site-controller, kirby-snippet-includes, vite-css-js-helpers, t()-translations]
key_files:
  created:
    - site/controllers/site.php
    - site/snippets/layout/header.php
    - site/snippets/layout/footer.php
    - site/snippets/components/language-switch.php
  modified:
    - site/templates/default.php
    - site/templates/home.php
    - src/css/main.css
decisions:
  - "Site controller (site.php) provides global data to all templates via Kirby controller pattern"
  - "Language switch uses $page->url($language->code()) for same-page language switching"
  - "Mobile menu uses Alpine.js x-data/x-show with x-transition for smooth open/close"
  - "Nav links use safe fallback with ternary ($site->find('page') ? url : '#') for pages not yet created"
metrics:
  duration: 285s
  completed: 2026-04-09
  status: checkpoint-pending
---

# Phase 1 Plan 2: Global Layout (Header, Footer, Language Switch) Summary

Site controller provides global contact/hours/social data; sticky header with desktop nav, Alpine.js mobile hamburger, and IT/EN language switch; three-column footer with contacts, hours, social; Candore-inspired dark/gold base styles with reusable button components.

## What Was Built

### Site Controller (`site/controllers/site.php`)
Global data provider for all templates: phone, whatsapp, email, address, hours (structure), social (structure). Uses Kirby's site controller pattern -- `site.php` runs for every template automatically.

### Header Snippet (`site/snippets/layout/header.php`)
- Full HTML document open: DOCTYPE, `<html lang>`, `<head>` with charset, viewport, title, `vite()->css()`
- Fixed header (`fixed top-0 w-full z-50 bg-dark`) with logo text, desktop nav, language switch
- Desktop nav (`hidden md:flex`): 7 links using `t()` for bilingual labels
- Mobile hamburger (`md:hidden`): Alpine.js `x-data="{ mobileOpen: false }"`, SVG toggle icons, slide-down panel with `x-transition`
- Body tag with `font-body bg-dark text-light pt-20` (offset for fixed header)

### Footer Snippet (`site/snippets/layout/footer.php`)
- Three-column responsive grid (`grid-cols-1 md:grid-cols-3`)
- Column 1: "Porta Vecia" brand, address (`nl2br`), phone (`tel:` link), WhatsApp (`wa.me` link), email
- Column 2: Opening hours from `$hours` structure loop with `t('footer.hours')` heading
- Column 3: Social links from `$social` structure loop with `t('footer.follow')` heading
- Copyright line with dynamic year
- `vite()->js()` before `</body></html>`

### Language Switch (`site/snippets/components/language-switch.php`)
- Loops `$kirby->languages()`, links to `$page->url($language->code())`
- Active language highlighted with `text-primary`, inactive with `text-light/60 hover:text-light`
- `aria-current="true"` on active language, `hreflang` on all links

### CSS Base Styles (`src/css/main.css`)
- `@layer base`: smooth scroll, body defaults, heading font family, link transitions
- `@layer components`: `.btn-primary`, `.btn-outline`, `.section-padding`, `.container-site`
- `[x-cloak]` directive for Alpine.js

### Templates Updated
- `default.php` and `home.php` use `snippet('layout/header')` and `snippet('layout/footer')`
- Content area with `max-w-4xl`, `prose prose-invert` for Kirby rich text

## Commits

| Task | Commit | Description |
|------|--------|-------------|
| 1 | d06415c | Site controller + layout snippets (header, footer, language switch) + templates |
| 2 | 9077a69 | Candore-inspired base styles, button components, x-cloak |

## Deviations from Plan

### Prerequisite Scaffolding (Rule 3 - Blocking Issue)

Plan 01 (Kirby scaffold + Vite pipeline) had not been executed in this worktree. Created all Plan 01 prerequisite files (Kirby install, config, languages, blueprints, Vite, Tailwind, Alpine) as a foundational commit to unblock Plan 02 execution.

## Checkpoint Pending

Task 3 (`checkpoint:human-verify`) requires visual verification:
- Sticky header with nav + language switch renders correctly
- Footer shows contacts, hours, social in 3-column grid
- Mobile hamburger menu opens/closes
- IT/EN language switch toggles all UI strings
- Candore-inspired dark/gold aesthetic

## Known Stubs

None -- all components are fully wired to Kirby data sources. Footer fields (phone, whatsapp, hours, social) will show empty until content is entered via Panel, which is expected behavior.

## Self-Check: PASSED

All 7 files verified present. Both commits (d06415c, 9077a69) verified in git log.
