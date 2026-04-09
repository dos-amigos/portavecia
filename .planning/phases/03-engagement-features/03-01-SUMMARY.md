---
phase: 03-engagement-features
plan: 01
subsystem: gallery
tags: [gallery, glightbox, alpine-js, masonry, multilingual]
dependency_graph:
  requires: [phase-02-core-pages]
  provides: [gallery-page, gallery-blueprint, gallery-filter, glightbox-lightbox]
  affects: [site-navigation, content-6-gallery]
tech_stack:
  added: [GLightbox 3.3.1 (CDN)]
  patterns: [CSS columns masonry, Alpine.js filter state, GLightbox elements API]
key_files:
  created:
    - site/blueprints/files/gallery-image.yml
    - site/blueprints/pages/gallery.yml
    - site/templates/gallery.php
    - content/6_gallery/gallery.it.txt
    - content/6_gallery/gallery.en.txt
    - content/6_gallery/*.jpeg (15 photos)
    - content/6_gallery/*.jpeg.it.txt (15 metadata files)
    - content/6_gallery/*.jpeg.en.txt (15 metadata files)
  modified:
    - src/js/main.js
    - site/languages/it.php
    - site/languages/en.php
decisions:
  - GLightbox loaded via CDN (same pattern as Leaflet in contact-map.php) rather than npm to keep it simple
  - Masonry via CSS columns (no JS library) for lightweight responsive grid
  - Filter rebuilds GLightbox instance so lightbox only cycles through visible photos
metrics:
  duration: 5 minutes
  completed: 2026-04-09
---

# Phase 3 Plan 1: Gallery Page Summary

Gallery page with masonry photo grid, Alpine.js category filters, and GLightbox lightbox -- 15 real photos from _sources/ pre-populated with bilingual metadata, fully editable from Kirby Panel.

## What Was Built

### Task 1: Gallery blueprints and content setup
- **File blueprint** (`gallery-image.yml`): accepts JPEG/PNG/WebP, fields for caption (translatable), alt (translatable), and category (select: locale/piatti/vini/cucina/eventi)
- **Page blueprint** (`gallery.yml`): two tabs -- content (headline + intro) and photos (files section with cards layout, template: gallery-image, sortable, 3/2 ratio)
- **Content**: 15 photos copied from `_sources/` to `content/6_gallery/` with bilingual `.it.txt`/`.en.txt` metadata files assigning categories (5 locale, 9 piatti, 1 cucina) and descriptive captions/alt text
- **Commit:** `2d6b5fd`

### Task 2: Gallery template with masonry grid, filters, and lightbox
- **Template** (`gallery.php`): follows established pattern (snippet header/footer), page header with headline + intro
- **Filter bar**: 6 buttons (Tutto, Locale, Piatti, Vini, Cucina, Eventi) using `t()` translation keys, Alpine.js active/inactive state toggle with Tailwind classes
- **Masonry grid**: CSS `columns-2 sm:columns-3 lg:columns-4` with `break-inside-avoid`, photos use `$image->thumb(['width' => 600])` for thumbnails, hover overlay with caption
- **GLightbox**: loaded via CDN (CSS + JS), integrated through `galleryFilter()` Alpine.js function in `main.js` that rebuilds lightbox from visible elements on filter change -- ensures lightbox only cycles filtered photos (D-05)
- **Translations**: 9 gallery keys added to both `it.php` and `en.php` (filter labels + empty state)
- **Commit:** `bf0bf37`

## Decisions Made

1. **GLightbox via CDN** -- consistent with Leaflet CDN pattern from contact-map.php, avoids adding npm dependency for a single-page feature
2. **CSS columns masonry** -- lightweight pure-CSS approach, no JavaScript masonry library needed, responsive via Tailwind breakpoints
3. **Lightbox rebuild on filter** -- GLightbox instance destroyed and rebuilt with only visible elements after each filter change, ensuring swipe navigation respects active filter

## Deviations from Plan

None -- plan executed exactly as written.

## Known Stubs

None -- all photos have real content from `_sources/`, all metadata populated with descriptive captions.

## Verification

- [x] `site/blueprints/files/gallery-image.yml` exists with category select field
- [x] `site/blueprints/pages/gallery.yml` exists with files section using template: gallery-image
- [x] `content/6_gallery/gallery.it.txt` and `gallery.en.txt` exist with Headline and Intro
- [x] 15 photos copied from `_sources/` with `.it.txt` and `.en.txt` metadata files
- [x] `site/templates/gallery.php` has masonry grid, Alpine.js filters, GLightbox CDN
- [x] `src/js/main.js` contains `galleryFilter()` with `buildLightbox()`
- [x] `site/languages/it.php` and `en.php` contain `gallery.filter.*` keys

## Self-Check: PASSED

All files exist. All commits verified.
