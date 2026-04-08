# Project Research Summary

**Project:** Porta Vecia (Wine Bar / Enoteca Website)
**Domain:** Local restaurant / wine bar website with bilingual CMS
**Researched:** 2026-04-08
**Confidence:** HIGH

## Executive Summary

Porta Vecia is a bilingual (IT/EN) website for a wine bar and enoteca in Este that pairs Italian wines with homemade Chinese cuisine. The recommended build approach uses Kirby CMS 5 (file-based, no database) with PHP 8.3+, Vite 8 for frontend bundling, Tailwind CSS 4 for styling, and Alpine.js for lightweight interactivity. This stack is well-documented, production-proven, and ideally suited for a content-managed local business site where the owner needs to update menus, wines, and events without developer assistance. The Candore HTML template serves as the design reference, informing the elegant, image-forward aesthetic.

The critical architectural decision is enabling Kirby multilingual system from the very first commit. Kirby fundamentally changes its content file structure when multilingual mode is activated, and retrofitting it after content exists causes painful migrations. The content model uses child pages for wines and events (which need individual URLs and rich detail views) and structure fields for menu dishes and opening hours (which are displayed inline on a single page). All content is managed through Kirby Panel with blueprints designed for the bar owner -- simple, well-labeled, with Italian help text.

The primary risks are: (1) content/code deployment collision since Kirby flat files mean Panel edits and Git deploys can overwrite each other -- solved by keeping content/ out of Git; (2) unoptimized images crushing performance on the gallery-heavy site -- solved by configuring Kirby thumb system with srcset presets and WebP conversion from the start; and (3) missing local SEO structured data, which is essential for a venue that depends on wine bar Este and enoteca near me searches. All three risks have well-established mitigation patterns documented in the research.

## Key Findings

### Recommended Stack

Kirby CMS 5 on PHP 8.3+ provides the content management foundation with built-in multilingual support, image processing, and an intuitive Panel for non-technical editors. The frontend uses Vite 8 for build tooling (integrated via johannschopplich/kirby-helpers plugin which also covers SEO utilities), Tailwind CSS 4 for rapid layout development across 7+ unique page types, and Alpine.js for interactive components like the mobile menu, language switcher, and gallery filtering. GSAP handles the Candore-style scroll animations; GLightbox and Swiper handle the gallery lightbox and carousels respectively.

**Core technologies:**
- **Kirby CMS 5.x**: File-based CMS with Panel admin -- no database, intuitive editing, native multilingual
- **PHP 8.3+**: Runtime requirement for Kirby 5, targeting long-term support versions
- **Vite 8 + kirby-helpers**: Frontend build pipeline with HMR and Kirby integration bridge
- **Tailwind CSS 4**: Utility-first CSS for 7+ distinct page layouts without custom CSS architecture
- **Alpine.js 3.x**: Lightweight reactivity for menu toggles, language switch, accordion UI
- **GSAP 3.x + ScrollTrigger**: Scroll-triggered entrance animations (now fully free)

### Expected Features

**Must have (table stakes):**
- Responsive design with sticky header navigation
- Homepage with hero imagery and fusion concept teaser
- HTML-native menu page (NOT PDF) with categories, descriptions, prices
- Curated wine showcase page with card grid layout
- Contact/location page with embedded map, hours, WhatsApp/phone CTAs
- About page with owners story and fusion concept narrative
- Bilingual IT/EN with context-preserving language switcher
- Footer with address, hours, phone, social links on every page
- Local SEO fundamentals (meta tags, hreflang, LocalBusiness schema)
- Cookie consent / GDPR compliance

**Should have (differentiators):**
- Fusion concept storytelling ("Two Traditions, One Table") -- THE unique selling point
- Food + wine pairing suggestions on menu and wine pages
- Events page for degustazioni and serate speciali
- Photo gallery with lightbox and categories
- Seasonal highlights / featured dish section on homepage
- Google Reviews quotes (manually curated)

**Defer indefinitely:**
- E-commerce / online wine shop
- Online reservation form (WhatsApp/phone is the channel)
- Blog / news section
- User accounts / loyalty program
- Full wine catalog with search/filters (curate 8-15 wines instead)
- AI chatbot, PDF menu download

### Architecture Approach

Kirby uses convention-based file matching: a content folder, blueprint, template, and controller share the same name and are auto-discovered. The content tree uses numbered prefixes for ordering, with Italian as the default language (root URLs like /vini) and English as secondary (/en/wines). Snippets are organized into three tiers: layout/ (header, footer, nav), sections/ (hero, featured wines, gallery grid), and components/ (wine card, dish item, language switch). Controllers handle all query logic; templates only compose snippets.

**Major components:**
1. **Content layer** (flat files) -- stores all text, media, and structured data; written by Panel, read by templates
2. **Blueprint layer** (YAML) -- defines Panel editing forms; reusable field groups via extends for dishes, SEO, images
3. **Template/Controller layer** (PHP) -- controllers handle data queries and logic; templates compose HTML from snippets
4. **Frontend layer** (CSS/JS) -- Tailwind for styling, Alpine.js for interactivity, GSAP for animations; bundled by Vite

### Critical Pitfalls

1. **Content/code deployment collision** -- Keep content/ in .gitignore from day 1. Use rsync to sync content between environments. Production is the source of truth for content.
2. **Multilingual setup done after content exists** -- Enable multilingual mode in the very first commit. Retrofitting requires migrating every content file and risks data loss.
3. **Language deletion destroys all its content** -- Restrict Panel language management to developer role only. Create a limited editor role for the bar owner. Maintain daily backups of content/.
4. **Unoptimized images killing performance** -- Configure Kirby thumb() with srcset presets, WebP conversion, and lazy loading from the start. Set upload size limits in blueprints.
5. **Vite dev/production build mismatch** -- Test npm run build locally before every deploy. Verify the kirby-helpers Vite bridge works in both dev and production modes.

## Implications for Roadmap

Based on combined research, the project naturally divides into 5 phases following dependency order.

### Phase 1: Foundation and Infrastructure
**Rationale:** Everything depends on multilingual routing, global layout, and correct project scaffolding. The bilingual setup MUST come first (Pitfall #2). Content/Git separation MUST be established immediately (Pitfall #1).
**Delivers:** Working Kirby installation with multilingual config, Vite build pipeline, Tailwind setup, global layout (header/footer/nav), language switcher, user roles (editor vs admin), .gitignore for content, hosting confirmation (Apache).
**Addresses:** Bilingual IT/EN system, responsive sticky navigation, footer with essential info, cookie consent shell.
**Avoids:** Pitfalls #1 (content in Git), #2 (late multilingual), #4 (language deletion risk), #8 (Vite mismatch), #11 (Apache assumption).

### Phase 2: Content Model and Core Pages
**Rationale:** Blueprints define the data model; templates cannot be built without content to render. Build page-by-page starting with the most important visitor destinations (menu, wines, contact).
**Delivers:** All page blueprints, reusable field blueprints (dishes, SEO), content folder structure with sample bilingual data, all templates and controllers, all component snippets.
**Addresses:** Homepage with hero, About page, Menu page (HTML-native), Wine showcase, Contact page with map/hours/WhatsApp, site-wide WhatsApp floating CTA.
**Avoids:** Pitfalls #3 (PDF menu), #5 (overengineered blueprints), #10 (hardcoded strings), #12 (missing essential info).

### Phase 3: Engagement Features
**Rationale:** These features build on the core content model. Gallery needs the file blueprint infrastructure. Events use the child-page pattern established for wines. Pairing suggestions reference both menu and wine content.
**Delivers:** Photo gallery with lightbox and categories, events page with upcoming/past split, food+wine pairing editorial suggestions, Google Reviews quotes, seasonal highlights section.
**Addresses:** Gallery, Events, fusion storytelling, pairing suggestions, seasonal content.
**Avoids:** Pitfall #9 (language switcher losing context -- test all new pages in both languages).

### Phase 4: SEO, Performance, and Polish
**Rationale:** SEO and performance optimization work best once all content and pages exist. Structured data references real content. Image optimization can be tuned against actual uploads.
**Delivers:** JSON-LD LocalBusiness/Restaurant schema, complete meta tag system with hreflang, image optimization pipeline (srcset, WebP, lazy loading), Kirby page cache configuration, hero video (if footage available), L Esperienza storytelling section, scroll animations (GSAP).
**Addresses:** Local SEO structured data, advanced meta tags, performance optimization, atmospheric polish.
**Avoids:** Pitfalls #6 (missing structured data), #7 (unoptimized images), #14 (cache invalidation).

### Phase 5: Deployment and Launch
**Rationale:** Production deployment is the final step, requiring all the infrastructure and content to be ready.
**Delivers:** Production hosting setup, deployment workflow (rsync), automated backup strategy for content/, SSL configuration, final QA pass in both languages, Google Business Profile reminder to client.
**Addresses:** Go-live readiness, backup strategy, content sync workflow.
**Avoids:** Pitfalls #1 (deployment collision), #11 (Apache/Nginx), #13 (no backups).

### Phase Ordering Rationale

- Multilingual and global layout must precede all content because Kirby file structure depends on language config being present.
- Content model (blueprints) must precede templates because templates render blueprint-defined fields.
- Core pages before engagement features because gallery, events, and pairings depend on the base content model and shared snippets.
- SEO and performance after content because structured data references real pages and image optimization needs actual uploads to tune.
- Deployment last because it requires the complete, tested site.

### Research Flags

Phases likely needing deeper research during planning:
- **Phase 2 (Content Model):** Blueprint design for the menu structure field needs careful UX consideration -- must be simple enough for the bar owner. Test with the client early.
- **Phase 4 (SEO):** JSON-LD schema for a dual-cuisine restaurant (Italian wine + Chinese food) may need custom servesCuisine array handling. Validate with Google Rich Results Test.

Phases with standard, well-documented patterns (skip phase research):
- **Phase 1 (Foundation):** Kirby multilingual setup, Vite integration, and Tailwind config all have official guides.
- **Phase 3 (Engagement):** Gallery, events, and editorial content are standard Kirby patterns with cookbook examples.
- **Phase 5 (Deployment):** Standard PHP shared hosting deployment with rsync.

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Stack | HIGH | All technologies are mature, well-documented, and version-pinned. Kirby 5, Vite 8, Tailwind 4 all have official docs. |
| Features | HIGH | Feature set derived from established restaurant/wine bar website patterns and the specific Porta Vecia concept. Clear MVP vs defer decisions. |
| Architecture | HIGH | Kirby convention-based architecture is thoroughly documented. Content tree, blueprint structure, and template organization follow official patterns. |
| Pitfalls | HIGH | Pitfalls sourced from official Kirby docs, community forums, and restaurant website industry articles. The critical pitfalls (content/Git, multilingual timing) are well-known Kirby gotchas. |

**Overall confidence:** HIGH

### Gaps to Address

- **Client content readiness:** The site depends on quality photography and bilingual copy. Clarify early whether the client will provide this or if professional photography / translation services are needed.
- **Hosting environment confirmation:** The stack assumes Apache with PHP 8.3+. Confirm the specific hosting provider and PHP version before Phase 1 begins.
- **GSAP scope:** GSAP animations are recommended for Candore-style polish but the exact animation inventory is not defined. Keep scope minimal -- fade-in on scroll and staggered reveals only. Avoid parallax overload.
- **Wine list management workflow:** The curated wine showcase (8-15 wines) needs a clear editorial workflow. Validate with the client how often wines rotate and whether the child-page model or a simpler structure field works better for their update pattern.

## Sources

### Primary (HIGH confidence)
- [Kirby CMS Requirements](https://getkirby.com/docs/reference/system/requirements)
- [Kirby 5 Release](https://getkirby.com/releases/5)
- [Kirby Multi-language Guide](https://getkirby.com/docs/guide/languages)
- [Kirby Blueprints Reference](https://getkirby.com/docs/reference/panel/blueprints)
- [Kirby Responsive Images Cookbook](https://getkirby.com/docs/cookbook/performance/responsive-images)
- [Kirby Snippets Guide](https://getkirby.com/docs/guide/templates/snippets)
- [Kirby Controllers Guide](https://getkirby.com/docs/guide/templates/controllers)
- [Tailwind CSS v4](https://tailwindcss.com/blog/tailwindcss-v4)
- [Vite Releases](https://vite.dev/releases)

### Secondary (MEDIUM confidence)
- [johannschopplich/kirby-helpers](https://github.com/johannschopplich/kirby-helpers) -- Vite + SEO plugin
- [tobimori/kirby-seo](https://github.com/tobimori/kirby-seo) -- fallback SEO plugin
- [Kirby Deployment Forum](https://forum.getkirby.com/t/deployment-flow-for-a-kirby-site-and-to-git-the-content-or-not/20065)
- [Candore Template Demo](https://duruthemes.com/demo/html/candore/demo1/)
- Restaurant website best practices (Paige Madden, Mediaboom, Highway 29 Creative)

### Tertiary (LOW confidence)
- Fusion restaurant references (Sesamo NYC, DaVinci and Yu) -- used for storytelling approach, not technical decisions

---
*Research completed: 2026-04-08*
*Ready for roadmap: yes*
