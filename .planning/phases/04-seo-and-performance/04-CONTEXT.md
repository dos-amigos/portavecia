# Phase 4: SEO and Performance - Context

**Gathered:** 2026-04-09
**Status:** Ready for planning

<domain>
## Phase Boundary

Implement technical SEO (meta tags, hreflang, JSON-LD structured data, sitemap) and image performance optimization (srcset, WebP, lazy loading) across all 7 site pages. Make meta title/description editable from Kirby Panel. Target: gallery and menu pages load under 3 seconds on 4G.

</domain>

<decisions>
## Implementation Decisions

### Claude's Discretion
User delegated all technical decisions to Claude. Follow best practices for:

- **D-01:** Meta tags strategy — use kirby-helpers plugin SEO features for meta title, description, Open Graph per page. Add SEO tab to each page blueprint for Panel editing.
- **D-02:** Hreflang implementation — Kirby's built-in multilingual URL handling with `<link rel="alternate" hreflang="it">` and `hreflang="en"` in header snippet.
- **D-03:** JSON-LD structured data — LocalBusiness/Restaurant schema on homepage and contact page. Include: name, address, phone, openingHours, servesCuisine (Italian wine + Chinese cuisine), menu URL, geo coordinates. Validate with Google Rich Results Test.
- **D-04:** Sitemap — use kirby-helpers sitemap generation for both language versions. Ensure all pages are included with correct hreflang alternates.
- **D-05:** Image optimization — configure Kirby srcset presets (320, 640, 960, 1280, 1920), WebP conversion via `format: 'webp'` in thumb(), native `loading="lazy"` on all images except above-the-fold hero.
- **D-06:** Performance targets — gallery and menu pages under 3 seconds on 4G. Compress hero video if present. Optimize Leaflet and GLightbox loading (already CDN-loaded on specific pages only).
- **D-07:** Robots.txt and canonical URLs — standard setup, prevent duplicate content between language versions.

</decisions>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

### Kirby SEO Documentation
- `https://getkirby.com/docs/cookbook/seo` — Kirby SEO cookbook
- `https://github.com/johannschopplich/kirby-helpers` — kirby-helpers plugin (already installed) with SEO meta helpers

### Phase Outputs (pages to optimize)
- `site/snippets/layout/header.php` — Add meta tags, hreflang, JSON-LD here
- `site/blueprints/pages/*.yml` — Add SEO tab to each page blueprint
- `site/blueprints/site.yml` — Global SEO defaults
- `site/templates/*.php` — All templates for image srcset optimization
- `site/snippets/sections/*.php` — All snippets with images for lazy loading

### Project Context
- `.planning/PROJECT.md` — Core value, requirements
- `.planning/REQUIREMENTS.md` — SEO-01 through SEO-04

</canonical_refs>

<code_context>
## Existing Code Insights

### Reusable Assets
- kirby-helpers plugin already installed — provides `$page->metaTitle()`, `$page->metaDescription()`, `$page->ogImage()`, sitemap routes
- Kirby built-in `thumb()` and `srcset()` methods with WebP support
- `site/controllers/site.php` — global data provider for JSON-LD (address, phone, hours)

### Established Patterns
- Header snippet includes all `<head>` content — add meta/hreflang/JSON-LD there
- Kirby's multilingual system handles URL alternates automatically
- Images currently use `thumb()` without srcset — needs upgrading
- Leaflet (contact) and GLightbox (gallery) loaded via CDN on specific pages only — already optimized

### Integration Points
- SEO tab added to all 7 page blueprints (home, about, menu, wines, contact, gallery, events)
- JSON-LD snippet in header for global structured data
- Srcset helper snippet for reusable responsive image patterns
- `site/config/config.php` for Kirby thumb and cache settings

</code_context>

<specifics>
## Specific Ideas

- JSON-LD servesCuisine should list both "Italian wine" and "Chinese cuisine" to reflect the unique positioning
- OpeningHours in structured data should match the hours from site.yml
- Gallery page images need aggressive srcset (many photos) — consider smaller default sizes
- Menu page dish cards currently have no photos (waiting for Panel upload) but srcset should be ready

</specifics>

<deferred>
## Deferred Ideas

None — discussion stayed within phase scope

</deferred>

---

*Phase: 04-seo-and-performance*
*Context gathered: 2026-04-09*
