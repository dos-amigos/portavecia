---
phase: 04-seo-and-performance
plan: 01
subsystem: seo
tags: [seo, meta-tags, json-ld, hreflang, sitemap, robots, blueprints]
dependency_graph:
  requires: []
  provides: [seo-meta-infrastructure, json-ld-structured-data, sitemap-xml, robots-txt, srcset-presets]
  affects: [site/config/config.php, site/snippets/layout/header.php, site/blueprints]
tech_stack:
  added: []
  patterns: [kirby-helpers-meta-cascade, page-model-metadata, json-ld-restaurant-schema]
key_files:
  created:
    - site/models/home.php
    - site/models/contact.php
  modified:
    - site/config/config.php
    - site/blueprints/site.yml
    - site/blueprints/pages/home.yml
    - site/blueprints/pages/about.yml
    - site/blueprints/pages/menu.yml
    - site/blueprints/pages/wines.yml
    - site/blueprints/pages/gallery.yml
    - site/blueprints/pages/events.yml
    - site/blueprints/pages/contact.yml
    - site/snippets/layout/header.php
decisions:
  - Used kirby-helpers plugin meta cascade for all SEO meta output (social, robots, jsonld)
  - Added structured address fields to site.yml instead of parsing freeform textarea for JSON-LD
  - Restructured contact.yml from flat fields to tabs layout to accommodate SEO tab
  - Used unicode regex for en-dash matching in opening hours parser
metrics:
  duration: 3min
  completed: 2026-04-09
  tasks_completed: 2
  tasks_total: 2
  files_changed: 12
requirements:
  - SEO-01
  - SEO-02
  - SEO-03
---

# Phase 04 Plan 01: SEO Infrastructure Summary

**One-liner:** Meta tags, OG, hreflang, JSON-LD Restaurant schema, sitemap/robots auto-generation, and Panel-editable SEO fields via kirby-helpers cascade on all 7 page blueprints.

## What Was Done

### Task 1: Config, blueprints, and header SEO infrastructure (f65d78e)

Updated `site/config/config.php` with:
- `johannschopplich.helpers.sitemap.enabled => true` for auto sitemap.xml generation
- `johannschopplich.helpers.robots.enabled => true` for auto robots.txt generation
- `johannschopplich.helpers.meta.defaults` function with site description fallback and OG locale (it_IT/en_US)
- 6 srcset presets: default, default-webp, card, card-webp, gallery, gallery-webp (for Plan 02)

Updated `site/blueprints/site.yml` with:
- SEO tab with description and thumbnail as global fallback fields
- Structured address fields: street_address, city, postal_code, latitude, longitude (for JSON-LD)

Added SEO tab to all 7 page blueprints (home, about, menu, wines, gallery, events, contact) with:
- customtitle (text, max 70 chars with counter)
- description (textarea, max 170 chars with counter)
- thumbnail (files field, single image)

Updated `site/snippets/layout/header.php`:
- Title tag uses `customtitle()->or($page->title())` with site name suffix
- Added `$page->meta()->robots()`, `->social()`, `->jsonld()` output
- Added hreflang link tags for IT, EN, and x-default via `$kirby->languages()` loop

### Task 2: JSON-LD page models for homepage and contact (6946eb8)

Created `site/models/home.php` (HomePage) and `site/models/contact.php` (ContactPage):
- Both return Restaurant JSON-LD via `metadata()` method
- Schema includes: name, description, url, telephone, servesCuisine (Italian Wine Bar + Chinese Cuisine), priceRange, PostalAddress, GeoCoordinates, openingHoursSpecification, image
- Homepage model also includes menu URL link
- `buildOpeningHours()` maps Italian day names to Schema.org English names and parses HH:MM time ranges

## Deviations from Plan

### Auto-fixed Issues

**1. [Rule 3 - Blocking] contact.yml restructured from flat fields to tabs layout**
- **Found during:** Task 1
- **Issue:** contact.yml used flat `fields:` structure without tabs, making it impossible to add an SEO tab alongside
- **Fix:** Restructured to `tabs:` with content tab containing existing fields + new seo tab
- **Files modified:** site/blueprints/pages/contact.yml
- **Commit:** f65d78e

**2. [Rule 1 - Bug] Unicode en-dash in regex for opening hours**
- **Found during:** Task 2
- **Issue:** Plan's regex used literal en-dash character which could cause encoding issues. Replaced with unicode escape `\x{2013}` with `/u` flag for reliable cross-platform matching.
- **Fix:** Used `[-\x{2013}]` pattern with `/u` flag in preg_match
- **Files modified:** site/models/home.php, site/models/contact.php
- **Commit:** 6946eb8

## Commits

| Task | Commit | Message |
|------|--------|---------|
| 1 | f65d78e | feat(04-01): add SEO infrastructure - meta tags, hreflang, sitemap, robots, srcset presets |
| 2 | 6946eb8 | feat(04-01): add JSON-LD Restaurant structured data for homepage and contact page |

## Known Stubs

None. All SEO infrastructure is fully wired. Panel fields cascade through kirby-helpers. JSON-LD pulls live data from site fields. Empty field values will simply produce empty/null JSON-LD properties until content is populated via Panel.

## Self-Check: PASSED

- All 5 key files verified present on disk
- Both commits (f65d78e, 6946eb8) verified in git log
