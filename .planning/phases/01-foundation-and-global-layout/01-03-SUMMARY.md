---
phase: 01-foundation-and-global-layout
plan: 03
subsystem: infra
tags: [cookie-consent, gdpr, garante-privacy, alpine-js, ga4, preventive-blocking]

# Dependency graph
requires:
  - phase: 01-foundation-and-global-layout
    provides: Kirby scaffold, Vite pipeline, Alpine.js, Tailwind CSS, layout snippets, bilingual t() system
provides:
  - GDPR/Garante Privacy 2021 compliant cookie consent system
  - Preventive GA4 blocking (no scripts load without explicit consent)
  - Bilingual cookie banner (IT/EN) with Alpine.js component
  - Granular consent categories (Technical, Analytics, Third-party)
  - Cookie Preferences footer link with reopenBanner() method
  - window.getCookieConsent() export for Maps click-to-load pattern
  - Custom events (cookie:thirdparty-accepted/refused) for inter-component communication
affects: [02-page-templates, contact-page-maps]

# Tech tracking
tech-stack:
  added: []
  patterns: [preventive-blocking, cookie-consent-alpine-component, t()-bilingual-strings, custom-event-dispatch]

key-files:
  created:
    - src/js/cookie-consent.js
    - site/snippets/components/cookie-banner.php
  modified:
    - src/js/main.js
    - site/snippets/layout/footer.php

key-decisions:
  - "Adapted tecnostudio reference implementation for Porta Vecia design tokens (bg-dark, text-light) and bilingual t() strings"
  - "Added reopenBanner() method and @cookie-reopen.window event listener for footer preferences link"
  - "All three main buttons (Accept/Reject/Customize) have equal visual prominence per Garante Privacy 2021 guidelines"

patterns-established:
  - "Cookie consent pattern: Alpine.js data component with preventive blocking and custom events"
  - "Bilingual snippet pattern: all user-facing strings use t('cookie.*') calls, never hardcoded"

requirements-completed: [INFRA-05]

# Metrics
duration: 5min
completed: 2026-04-09
---

# Phase 1 Plan 3: Cookie Consent Summary

**GDPR/Garante Privacy 2021 compliant cookie consent with preventive GA4 blocking, bilingual Alpine.js banner, and granular category management**

## Performance

- **Duration:** 5 min
- **Started:** 2026-04-09T08:25:06Z
- **Completed:** 2026-04-09T08:30:00Z
- **Tasks:** 1 of 2 (Task 2 is checkpoint:human-verify, pending)
- **Files modified:** 4

## Accomplishments
- Alpine.js cookieConsent component with full consent lifecycle (accept, reject, customize, save, reopen)
- Bilingual cookie banner PHP snippet using t() calls -- zero hardcoded Italian strings
- Preventive GA4 blocking: script loads only after explicit user consent via dynamic script injection
- Three equal-prominence buttons (Accept/Reject/Customize) per Garante Privacy 2021 compliance
- Granular categories: Technical (always on), Analytics (toggle), Third-party (toggle)
- 180-day cookie expiry per Garante guidelines
- Footer Cookie Preferences link that dispatches cookie-reopen event to reopen banner
- window.getCookieConsent() export for future Maps click-to-load integration
- Custom events (cookie:thirdparty-accepted/refused) for inter-component communication
- Vite build passes with cookie-consent.js bundled successfully

## Task Commits

Each task was committed atomically:

1. **Task 1: Create cookie consent Alpine.js component and bilingual banner snippet** - `7ed530e` (feat)
2. **Task 2: Verify cookie consent compliance and bilingual behavior** - PENDING (checkpoint:human-verify)

## Files Created/Modified
- `src/js/cookie-consent.js` - Alpine.js cookieConsent component with GA4 loading, consent storage, custom events
- `site/snippets/components/cookie-banner.php` - GDPR-compliant bilingual banner UI with equal-weight buttons and customize panel
- `src/js/main.js` - Added import for cookie-consent.js before Alpine.start()
- `site/snippets/layout/footer.php` - Added cookie banner snippet include and Cookie Preferences link

## Decisions Made
- Adapted tecnostudio reference implementation for Porta Vecia design tokens (bg-dark instead of bg-anthracite, text-light instead of text-white)
- Added reopenBanner() method with @cookie-reopen.window event for footer preferences link
- All three main buttons equal visual prominence per Garante Privacy 2021 (same size, similar contrast)

## Deviations from Plan

None - plan executed exactly as written.

## Issues Encountered
None.

## User Setup Required
None - no external service configuration required.

## Known Stubs
None - all functionality is fully wired.

## Next Phase Readiness
- Cookie consent system ready for use across all pages
- GA4 will activate when measurement ID is entered in Panel (ga4MeasurementId field)
- Third-party consent events ready for Maps integration in Phase 2 contact page
- Pending: human verification of visual compliance and bilingual behavior (Task 2 checkpoint)

## Self-Check: PASSED

All created files verified present. Commit 7ed530e verified in git log.

---
*Phase: 01-foundation-and-global-layout*
*Completed: 2026-04-09*
