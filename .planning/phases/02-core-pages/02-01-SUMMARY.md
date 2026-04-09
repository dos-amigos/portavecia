---
phase: 02-core-pages
plan: 01
subsystem: homepage
tags: [homepage, hero-video, whatsapp, kirby-blueprint, bilingual]
dependency_graph:
  requires: [01-01, 01-02]
  provides: [homepage-template, whatsapp-float, homepage-blueprint]
  affects: [footer]
tech_stack:
  added: []
  patterns: [section-snippets, tabbed-blueprint, structure-fields]
key_files:
  created:
    - site/blueprints/pages/home.yml
    - site/snippets/sections/hero-video.php
    - site/snippets/sections/section-teaser.php
    - site/snippets/sections/section-preview.php
    - site/snippets/sections/section-story.php
    - site/snippets/components/whatsapp-float.php
    - content/home/home.it.txt
    - content/home/home.en.txt
  modified:
    - site/templates/home.php
    - site/snippets/layout/footer.php
    - site/languages/it.php
    - site/languages/en.php
decisions:
  - Section order: Hero -> Fusion Teaser -> Featured Previews -> L'Esperienza (optimized for engagement per D-02)
  - Mobile video: hidden on mobile with poster image fallback for performance
  - Preview placeholders: grey boxes with item name when no image uploaded yet
metrics:
  duration: 4 minutes
  completed: 2026-04-09
---

# Phase 02 Plan 01: Homepage Summary

Video hero homepage with fusion teaser, featured dishes/wines previews, storytelling section, and global floating WhatsApp button -- all Kirby Panel-editable with bilingual IT/EN content.

## What Was Done

### Task 1: Homepage blueprint and bilingual content files
- Replaced basic title+text blueprint with full tabbed structure (4 tabs: Hero, Fusion Teaser, Anteprime, L'Esperienza)
- Hero tab: title, subtitle, video background (mp4 file picker), poster image
- Previews tab: featured_dishes and featured_wines as structure fields (max 3 each) with name, description, image
- Created bilingual content files with realistic placeholder text (gitignored, managed via Panel)
- **Commit:** `5ba3f70`

### Task 2: Homepage template and section snippets
- Replaced placeholder home.php with composable section-based template
- `hero-video.php`: full-viewport video background (autoplay/muted/loop/playsinline), dark overlay, centered title/subtitle, WhatsApp CTA button, scroll indicator; hides video on mobile showing poster fallback
- `section-teaser.php`: two-column grid with image left, kirbytext right for fusion concept
- `section-preview.php`: 3-column card grids for featured dishes and wines with placeholder boxes when no images, "Scopri" link buttons to menu/wines pages
- `section-story.php`: two-column storytelling with overlapping dual images
- Added 6 homepage translation keys to both IT and EN language files
- **Commit:** `c628185`

### Task 3: Floating WhatsApp button (global)
- Created `whatsapp-float.php` component: fixed bottom-right (z-40), WhatsApp green (#25D366), hover scale animation
- Conditional render: only shows when $whatsapp field has value
- Included in footer.php before cookie-banner for site-wide visibility
- **Commit:** `d6eda31`

## Deviations from Plan

None - plan executed exactly as written.

## Known Stubs

- Content files (home.it.txt, home.en.txt) contain placeholder text that will be replaced with final client copy
- Featured dishes/wines images are empty arrays `[]` -- will be populated via Kirby Panel when photos are available
- Hero video and poster image fields are empty -- need actual video file (preparazione-spaghetti-di-riso.mp4 from _sources/) and poster to be uploaded via Panel

These stubs are intentional: content is managed via Kirby Panel in production, and content/ is gitignored. The templates gracefully handle missing images with placeholder boxes.

## Commits

| Task | Commit | Description |
|------|--------|-------------|
| 1 | `5ba3f70` | Homepage blueprint with tabbed Panel editing |
| 2 | `c628185` | Homepage template with 4 section snippets + translation keys |
| 3 | `d6eda31` | Global floating WhatsApp button |

## Self-Check: PASSED

All 9 files verified present. All 3 commits verified in git history.
