# Domain Pitfalls

**Domain:** Kirby CMS wine bar / enoteca website (bilingual IT/EN)
**Project:** Porta Vecia
**Researched:** 2026-04-08

## Critical Pitfalls

Mistakes that cause rewrites, data loss, or major rework.

### Pitfall 1: Content/Code Deployment Collision

**What goes wrong:** Kirby is file-based -- Panel edits write directly to `content/` on the server filesystem. If you track `content/` in Git and deploy by pushing, you overwrite client edits. If you don't track it, you lose version history and have no easy way to seed content across environments.

**Why it happens:** Developers instinctively `git add .` everything. Kirby's flat-file nature means content and code live in the same filesystem, unlike database-backed CMSs where content is separate by default.

**Consequences:** Client edits lost on deploy. Or: merge conflicts in YAML content files that corrupt page data. Or: dev and production content drift apart with no sync mechanism.

**Prevention:**
- Keep `content/` OUT of Git from day 1. Add it to `.gitignore`.
- Use rsync for content sync between environments (pull from production to dev, never push dev content to production).
- Set up a `shared/content` symlink strategy if using zero-downtime deploys.
- Seed initial content manually or via a one-time script, then treat production as the source of truth.

**Detection:** If `git status` shows content file changes after Panel edits, your `.gitignore` is wrong.

**Phase:** Must be addressed in Phase 1 (project scaffolding / infrastructure).

---

### Pitfall 2: Multilingual Setup Done After Content Exists

**What goes wrong:** Kirby's multilingual system changes how content files work -- each language gets its own file extension (e.g., `default.it.txt`, `default.en.txt`). Converting a single-language site to multilingual after content exists requires migrating every content file. The default language content file is THE fallback -- if it's missing, Kirby breaks.

**Why it happens:** Developers build "just Italian first, we'll add English later." But Kirby's multilingual mode is a fundamental architectural switch, not an afterthought.

**Consequences:** Manual migration of every content file. Routing breaks during conversion. Risk of data loss if language files are misconfigured. Panel shows empty pages.

**Prevention:**
- Enable multilingual mode from the very first commit. The PROJECT.md already specifies "bilingue IT/EN dal giorno 1" -- follow this literally.
- Define Italian as the default language, English as secondary.
- Always ensure default language content files exist for every page, even if English translations come later (Kirby falls back to default language).
- Never define more than one default language.

**Detection:** If `site/languages/` folder is empty or missing, multilingual is not configured. Check early.

**Phase:** Phase 1 (project scaffolding). Non-negotiable.

---

### Pitfall 3: PDF Menus Instead of HTML Content

**What goes wrong:** Restaurant owners upload a PDF of their menu. It looks "easy" but is an SEO and UX disaster -- not indexable by search engines, not responsive on mobile, not translatable per-language, not editable field-by-field in the Panel.

**Why it happens:** The client already has a PDF menu and thinks uploading it is simpler than entering items individually.

**Consequences:** Zero SEO value from menu content (Google cannot extract structured data from PDFs). Terrible mobile experience -- users pinch-zoom a PDF on their phone. Menu cannot be bilingual without maintaining two separate PDFs. Updates require regenerating the entire PDF.

**Prevention:**
- Model menu items as structured content in Kirby blueprints: name, description, price, category, dietary info, each as separate fields.
- Use structure fields or subpages for menu items so each dish is a structured entry.
- Explicitly tell the client during onboarding: "You edit each dish in the Panel, the website formats it beautifully."
- If the client insists on also having a downloadable PDF, generate it from the structured data or offer it as a secondary option, never as the primary display.

**Detection:** If any blueprint has a single "files" field labeled "Menu PDF" -- stop and restructure.

**Phase:** Phase 2 (content modeling / blueprints).

---

### Pitfall 4: Deleting a Language Destroys All Its Content

**What goes wrong:** Kirby's language deletion is irreversible and removes ALL content files for that language. If someone accidentally deletes the default language, the entire site's content is wiped.

**Why it happens:** Language management is accessible in the Panel. A non-technical admin might "clean up" or experiment.

**Consequences:** Complete content loss for the deleted language. If the default language is deleted, catastrophic data loss.

**Prevention:**
- Restrict Panel language management to the developer role only (not the client's editor account).
- Use Kirby's user roles: create an "editor" role that can edit content but cannot access system settings or language configuration.
- Maintain server-level backups (daily automated backups of the entire `content/` directory).

**Detection:** Check user role permissions in blueprints. If the client account has "admin" role, fix immediately.

**Phase:** Phase 1 (user roles setup) and ongoing (backup strategy).

---

## Moderate Pitfalls

### Pitfall 5: Overengineered Blueprints That Confuse Editors

**What goes wrong:** Developers create deeply nested, multi-tab blueprints with dozens of fields per page. The wine bar owner opens the Panel, sees 15 fields for a single wine entry, and either fills them wrong, leaves them blank, or gives up entirely.

**Why it happens:** Developers model content for maximum flexibility instead of for the actual editor's workflow.

**Prevention:**
- Design blueprints for the person using them (the bar owner), not for developer elegance.
- For wine entries: name, image, short description, price. That's it for v1. Add "grape variety" or "region" only if the client will actually fill them in.
- For menu items: name, description, price, category. No "allergen matrix" or "nutritional info" unless requested.
- Use field `help` text in Italian to guide the editor ("Inserisci il nome del piatto come appare nel menu").
- Use `placeholder` values as examples.
- Use columns and tabs to organize visually, not to add more fields.

**Detection:** If a blueprint YAML is over 60 lines for a single page type, it's probably too complex. Ask: "Will the client fill in every field?"

**Phase:** Phase 2 (content modeling / blueprints).

---

### Pitfall 6: Missing Local SEO Structured Data

**What goes wrong:** The site launches without Schema.org `Restaurant` / `LocalBusiness` structured data, without a proper Google Business Profile link, and without consistent NAP (Name, Address, Phone) across pages. Local search visibility suffers.

**Why it happens:** Developer focuses on meta titles/descriptions and forgets that local businesses need specific structured data for Google Maps, Knowledge Panels, and local pack results.

**Consequences:** Restaurant doesn't appear in "enoteca near me" or "wine bar Este" searches. Google cannot extract opening hours, address, cuisine type, or price range.

**Prevention:**
- Implement JSON-LD structured data on every page using `LocalBusiness` and `Restaurant` schema types. Include: name, address, phone, opening hours, cuisine type ("Italian", "Chinese"), price range, geo coordinates, image.
- Use the `kirby-meta` plugin (by Fabian Michael) for meta tags and JSON-LD generation, or build a custom snippet.
- Ensure NAP (Name, Address, Phone) is consistent in the footer, contact page, and structured data -- identical strings everywhere.
- Add `sameAs` links to Google Business Profile, Instagram, TripAdvisor if they exist.
- Set up Google Business Profile separately (not a website task, but remind the client).

**Detection:** Use Google's Rich Results Test on the live URL. If no structured data is detected, it's missing.

**Phase:** Phase 3 (SEO implementation) but plan the schema structure in Phase 2.

---

### Pitfall 7: Unoptimized Images Killing Performance

**What goes wrong:** The client uploads 5MB DSLR photos directly through the Panel. No automatic resizing, no WebP conversion, no lazy loading. Pages take 10+ seconds to load on mobile, especially the gallery page.

**Why it happens:** Kirby does have thumb generation, but it doesn't automatically optimize uploads. Without explicit configuration, original files are served.

**Consequences:** Terrible Core Web Vitals (LCP, CLS). Google penalizes slow sites in mobile search. Users on cellular connections abandon the site. The gallery page becomes unusable.

**Prevention:**
- Configure Kirby's built-in `thumb()` method with sensible defaults for each context (hero: 1920px wide, gallery thumbnails: 600px, wine cards: 400px).
- Enable WebP/AVIF conversion via Kirby's `thumbs` config or the `kirby-imagex` plugin.
- Implement `srcset` and `sizes` attributes for responsive images using Kirby's built-in helpers.
- Add lazy loading (`loading="lazy"`) to all below-fold images.
- Consider the `kirby-image-optimizer` plugin to auto-compress Panel uploads.
- Set upload file size limits in the blueprint (`maxsize: 5000` in KB) and add help text telling the client to resize photos before uploading, or auto-resize on upload.

**Detection:** Run Lighthouse on the gallery page. If LCP > 2.5s, images need optimization.

**Phase:** Phase 2 (template development) for thumbs config; Phase 3 for fine-tuning.

---

### Pitfall 8: Vite Dev Server / Production Build Mismatch

**What goes wrong:** Frontend works perfectly in development (Vite dev server with HMR), but breaks in production because the manifest file is missing, asset paths are wrong, or the kirby-vite plugin isn't configured for both modes.

**Why it happens:** Developer works exclusively with `npm run dev` and never tests a production build locally. The kirby-vite plugin switches between dev server URLs and manifest-based paths, and the toggle logic has edge cases.

**Consequences:** Broken CSS/JS on the live site. Blank pages. Client sees an unstyled mess after deploy.

**Prevention:**
- Test `npm run build` + production mode locally before every deploy.
- Ensure the kirby-vite plugin's environment detection works correctly (check `KIRBY_MODE` or equivalent env var).
- Include production build in your deployment checklist / CI pipeline.
- Keep the Vite config simple -- avoid complex multi-entry setups unless needed.

**Detection:** If `assets/build/manifest.json` doesn't exist after `npm run build`, the pipeline is broken.

**Phase:** Phase 1 (project scaffolding) for initial setup; verify at every deploy.

---

### Pitfall 9: Language Switcher That Loses Context

**What goes wrong:** User is viewing the wine page in Italian, clicks the EN switch, and lands on the English homepage instead of the English wine page. Or worse, gets a 404 because the English translation doesn't exist yet.

**Why it happens:** The language switcher links to the other language's root URL instead of the translated version of the current page. Or translations are incomplete and there's no fallback strategy.

**Consequences:** Frustrating UX. Tourists (a key target audience for Porta Vecia) can't navigate in English.

**Prevention:**
- Use Kirby's `$page->url('en')` to generate language-specific URLs for the current page.
- Implement a fallback: if the English translation doesn't exist, fall back to Italian content (Kirby does this by default for the default language, but the switcher UI should handle it gracefully).
- Show the language switcher only for languages where the current page has content, or visually indicate "partial translation."
- Test every page in both languages before launch.

**Detection:** Click through every page in both languages during QA. Check that the URL changes but the page context stays the same.

**Phase:** Phase 2 (templates) for implementation; Phase 4 (QA) for testing.

---

## Minor Pitfalls

### Pitfall 10: Hardcoded Text in Templates

**What goes wrong:** Strings like "Prenota ora", "I nostri vini", "Orari di apertura" are hardcoded in PHP templates instead of using Kirby's translation system. When the site switches to English, these strings stay in Italian.

**Prevention:**
- Use `t('key')` translation helper for ALL UI strings from day 1.
- Create `site/languages/it.php` and `site/languages/en.php` with all UI translations.
- Never write literal Italian text in template files. Not even "Menu" (it's different in some contexts).

**Phase:** Phase 2 (template development). Enforce from the first template.

---

### Pitfall 11: Apache vs Nginx .htaccess Assumption

**What goes wrong:** Kirby relies on `.htaccess` for URL rewriting and security headers. If deployed to Nginx (no `.htaccess` support), routes break and the Panel is inaccessible.

**Prevention:**
- Confirm the hosting environment uses Apache before development begins.
- If Nginx is required, manually translate `.htaccess` rules to Nginx config blocks (Kirby docs provide guidance, but it's manual work).
- Document the hosting requirement in the project README.

**Phase:** Phase 1 (hosting decision).

---

### Pitfall 12: Missing Essential Restaurant Information

**What goes wrong:** The website launches beautiful but is missing the one thing 80% of visitors came for: opening hours, phone number, or address. Or these are buried three clicks deep.

**Prevention:**
- Opening hours, address, and phone/WhatsApp must appear on EVERY page (footer minimum).
- Make these fields editable in a single "site" blueprint so the client updates them once and they propagate everywhere.
- Don't rely on the contact page alone -- most users won't navigate there.

**Phase:** Phase 2 (site blueprint + footer template).

---

### Pitfall 13: No Backup Strategy for Flat-File Content

**What goes wrong:** Server disk failure, accidental deletion, or a botched deploy wipes the `content/` directory. Because there's no database dump to restore from, everything is gone.

**Prevention:**
- Set up automated daily backups of the `content/` and `media/` directories.
- Use a simple cron job with rsync to a secondary location, or hosting-provider snapshots.
- Test restore from backup at least once before launch.

**Phase:** Phase 1 (infrastructure setup).

---

### Pitfall 14: Ignoring Cache Invalidation

**What goes wrong:** Kirby's page cache serves stale content after Panel edits. Client updates the menu, but visitors see the old version for hours.

**Prevention:**
- Understand Kirby's cache behavior: page cache is automatically invalidated on Panel saves for the affected page, but custom caches or CDN caches may not be.
- If using a CDN (Cloudflare, etc.), set appropriate cache TTLs and consider cache purge on deploy.
- Test: edit content in Panel, then load the page in an incognito browser. If old content shows, investigate caching layers.

**Phase:** Phase 3 (deployment / hosting config).

---

## Phase-Specific Warnings

| Phase Topic | Likely Pitfall | Mitigation |
|---|---|---|
| Project scaffolding | Content in Git (#1), multilingual not enabled (#2) | `.gitignore` content/, enable languages from first commit |
| Content modeling | Overengineered blueprints (#5), PDF menus (#3), hardcoded strings (#10) | Design for the editor, structure all content, use `t()` |
| Template development | Image optimization (#7), language switcher (#9), Vite build (#8) | Configure thumbs early, test both languages, test prod builds |
| SEO | Missing structured data (#6), missing essential info (#12) | JSON-LD LocalBusiness schema, NAP in footer |
| Deployment | Content/code collision (#1), Apache assumption (#11), no backups (#13) | rsync workflow, verify hosting, automated backups |
| User access | Language deletion risk (#4), admin role for client | Restricted editor role, server backups |

## Sources

- [Kirby Multi-language Guide](https://getkirby.com/docs/guide/languages) -- official docs, HIGH confidence
- [Kirby Responsive Images Cookbook](https://getkirby.com/docs/cookbook/performance/responsive-images) -- official docs, HIGH confidence
- [Kirby Deployment Forum Discussion](https://forum.getkirby.com/t/deployment-flow-for-a-kirby-site-and-to-git-the-content-or-not/20065) -- community, MEDIUM confidence
- [Kirby Git Content Plugin](https://plugins.getkirby.com/thathoff/git-content) -- plugin registry, MEDIUM confidence
- [kirby-meta Plugin (Fabian Michael)](https://github.com/fabianmichael/kirby-meta) -- GitHub, MEDIUM confidence
- [kirby-imagex Plugin](https://github.com/timnarr/kirby-imagex) -- GitHub, MEDIUM confidence
- [kirby-vite Plugin](https://github.com/arnoson/kirby-vite) -- GitHub, MEDIUM confidence
- [Restaurant Website Common Mistakes](https://www.sumydesigns.com/restaurant-website-mistakes/) -- industry article, MEDIUM confidence
- [Restaurant SEO Mistakes](https://localbrandhub.com/blog/restaurant-seo-mistakes) -- industry article, MEDIUM confidence
- [Kirby Blueprints Guide](https://getkirby.com/docs/guide/blueprints/introduction) -- official docs, HIGH confidence
- [Kirby Forum: When is Kirby not the right fit?](https://forum.getkirby.com/t/when-is-kirby-not-the-right-fit/24911) -- community, MEDIUM confidence
