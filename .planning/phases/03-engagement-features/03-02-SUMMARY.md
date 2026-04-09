---
phase: 03-engagement-features
plan: 02
subsystem: ui
tags: [kirby, events, whatsapp, structure-field, multilingual]

# Dependency graph
requires:
  - phase: 02-core-pages
    provides: "Global layout (header/footer), site controller ($whatsapp), dish-card pattern, translation system"
provides:
  - "Events page at /eventi (IT) and /en/events (EN)"
  - "Event card snippet with WhatsApp booking CTA"
  - "Events controller with upcoming/past date splitting"
  - "Events blueprint with structure field for Panel editing"
affects: [04-seo-and-performance]

# Tech tracking
tech-stack:
  added: []
  patterns: [event-date-filtering, whatsapp-rawurlencode, past-event-dimming]

key-files:
  created:
    - site/blueprints/pages/events.yml
    - site/controllers/events.php
    - site/templates/events.php
    - site/snippets/sections/event-card.php
    - content/7_events/events.it.txt
    - content/7_events/events.en.txt
  modified:
    - site/languages/it.php
    - site/languages/en.php

key-decisions:
  - "Used separate date and time fields (type: date + type: time) instead of datetime to avoid Kirby pitfalls"
  - "WhatsApp message uses str_replace with rawurlencode for proper URL encoding"
  - "Past events dimmed with opacity-60 CSS class, no booking button shown"

patterns-established:
  - "Event date filtering: toDate() comparison against time() for upcoming/past split"
  - "Conditional CTA: WhatsApp booking button only on upcoming events with whatsapp_booking toggle enabled"

requirements-completed: [EVNT-01, EVNT-02, EVNT-03]

# Metrics
duration: 5min
completed: 2026-04-09
---

# Phase 3 Plan 2: Events Summary

**Events page with upcoming/past card layout, WhatsApp booking CTAs, and 4 bilingual placeholder events editable from Kirby Panel**

## Performance

- **Duration:** 5 min
- **Started:** 2026-04-09T14:02:59Z
- **Completed:** 2026-04-09T14:08:00Z
- **Tasks:** 2
- **Files modified:** 10

## Accomplishments
- Events page with 3 upcoming and 1 past event, visually split with date-based filtering
- Event cards adapted from dish-card pattern with date badge, photo, description, and conditional WhatsApp CTA
- Past events rendered with dimmed opacity-60 styling and no booking button
- Full bilingual IT/EN support with 9 translation keys per language

## Task Commits

Each task was committed atomically:

1. **Task 1: Events blueprint, controller, and content with placeholder events** - `0e77403` (feat)
2. **Task 2: Events template, event card snippet, and translation keys** - `f3d020e` (feat)

## Files Created/Modified
- `site/blueprints/pages/events.yml` - Events page blueprint with structure field for Panel editing
- `site/controllers/events.php` - Controller splitting events into upcoming and past by date
- `site/templates/events.php` - Events page template with upcoming/past/empty sections
- `site/snippets/sections/event-card.php` - Event card component with photo, date badge, WhatsApp CTA
- `content/7_events/events.it.txt` - 4 placeholder events in Italian
- `content/7_events/events.en.txt` - 4 placeholder events in English
- `content/7_events/*.jpeg` - 4 event photos copied from _sources/
- `site/languages/it.php` - Added 9 events translation keys
- `site/languages/en.php` - Added 9 events translation keys

## Decisions Made
- Used separate `type: date` and `type: time` fields instead of a combined datetime to avoid Kirby date handling pitfalls
- WhatsApp message constructed with str_replace for event name/date placeholders and rawurlencode for URL safety
- Past events show dimmed styling (opacity-60) and hide booking button, matching the plan's visual spec

## Deviations from Plan

### Auto-fixed Issues

**1. [Rule 2 - Missing Critical] Added 'event.ore' translation key**
- **Found during:** Task 2 (event-card snippet)
- **Issue:** The event card displays time as "ore 19:30" (IT) / "at 19:30" (EN), but no translation key was specified in the plan for the "ore"/"at" label
- **Fix:** Added 'event.ore' key to both it.php ("ore") and en.php ("at")
- **Files modified:** site/languages/it.php, site/languages/en.php
- **Committed in:** f3d020e (Task 2 commit)

---

**Total deviations:** 1 auto-fixed (1 missing critical)
**Impact on plan:** Minor addition for proper i18n of time display. No scope creep.

## Issues Encountered
None

## User Setup Required
None - no external service configuration required.

## Next Phase Readiness
- Events page complete, ready for Phase 4 SEO optimization (meta tags, structured data)
- Gallery page (03-01) is the parallel plan in this phase

## Self-Check: PASSED

All 6 key files verified present. Both task commits (0e77403, f3d020e) verified in git log.

---
*Phase: 03-engagement-features*
*Completed: 2026-04-09*
