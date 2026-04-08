# Phase 1: Foundation and Global Layout - Research

**Researched:** 2026-04-08
**Domain:** Kirby 5 CMS setup, Vite 8 build pipeline, Tailwind CSS 4, multilingual IT/EN, global layout, cookie consent
**Confidence:** HIGH

## Summary

Phase 1 establishes the entire project foundation: a working Kirby 5 installation with bilingual IT/EN routing from the first commit, a Vite 8 + Tailwind CSS 4 + Alpine.js build pipeline, and the global shell (sticky header with logo/nav/language switch, footer with contacts/hours/social) visible on every page. It also includes a GDPR-compliant cookie consent system with preventive blocking per Garante Privacy 2021 guidelines.

The stack is well-established and all libraries are verified current. The critical architectural decisions -- multilingual from day 1, content/ in .gitignore, Vite manifest-based dev/prod switching -- are well-documented in Kirby ecosystem best practices. The cookie consent implementation has a production-proven reference in the tecnostudio project that can be adapted directly.

**Primary recommendation:** Scaffold Kirby 5 via Composer plainkit, enable multilingual immediately, configure Vite 8 with kirby-helpers plugin for asset bridging, build the global layout snippets (header/footer/nav) with Tailwind 4 utilities, and port the tecnostudio cookie consent Alpine.js component with bilingual strings.

## Project Constraints (from CLAUDE.md)

- **Commit frequenti e descrittivi** -- every change committed immediately with detailed message
- **Non inventarsi nulla** -- never take initiative on unrequested changes; ask confirmation for complex/risky modifications
- **Cercare online, non fidarsi della memoria** -- verify everything against official docs; never rely on AI memory alone
- **GSD Workflow Enforcement** -- all changes through GSD commands, no direct repo edits outside workflow
- **Tech stack**: Kirby CMS (PHP) -- required explicitly by client
- **Lingue**: Italiano + Inglese from day 1
- **Prenotazioni**: WhatsApp/telefono only, no forms or external booking services
- **Content/ in .gitignore from day 1** (STATE.md decision)
- **Multilingual IT/EN from first commit** (STATE.md decision)

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|----|-------------|------------------|
| INFRA-01 | Kirby 5 with multilingual IT/EN from first commit | Kirby multilingual guide: define languages in site/languages/, enable in config.php, Italian as default with root URLs, English with /en/ prefix |
| INFRA-02 | Vite 8 + Tailwind CSS 4 + Alpine.js pipeline | kirby-helpers v6.7.1 provides vite() helpers; @tailwindcss/vite plugin for Tailwind 4; Alpine.js via npm import |
| INFRA-03 | Global layout with sticky header (logo, nav, language switch) and footer (contatti, orari, social) | Kirby snippet architecture: layout/header.php, layout/footer.php, components/language-switch.php; site.yml blueprint for global fields |
| INFRA-04 | Responsive mobile-first design inspired by Candore | Tailwind 4 mobile-first utilities; Candore template analysis provides design tokens (dark backgrounds, gold accents, serif headings) |
| INFRA-05 | Cookie consent with preventive blocking (Garante Privacy 2021) | Tecnostudio reference implementation: Alpine.js component (113 lines) + banner snippet (100 lines); adapt with bilingual t() strings |
| LANG-02 | Language switch visible in header | Kirby $page->url($language->code()) pattern; Alpine.js for mobile toggle |
| LANG-03 | UI strings translated via Kirby t() system | Language files in site/languages/it.php and en.php with translations array |
</phase_requirements>

## Standard Stack

### Core (Phase 1 specific)

| Library | Version | Purpose | Why Standard |
|---------|---------|---------|--------------|
| Kirby CMS | 5.x (5.3.3) | CMS, Panel, multilingual routing | Client requirement; file-based, no DB needed |
| PHP | 8.2+ (8.2.12 available locally) | Runtime | Kirby 5 minimum; local environment has 8.2.12 |
| Composer | 2.x (2.4.4 available locally) | PHP dependency management | Standard for Kirby installation |
| Vite | 8.0.7 | Build tool, HMR dev server | Current stable; Rolldown-based builds |
| @tailwindcss/vite | 4.2.2 | Tailwind CSS Vite plugin | Native Vite plugin for Tailwind 4; no PostCSS config needed |
| Tailwind CSS | 4.x (via @tailwindcss/vite) | Utility-first CSS | CSS-first config, automatic content detection |
| @tailwindcss/typography | 0.5.19 | Prose styling for CMS content | Styles Kirby rich text output |
| Alpine.js | 3.15.11 | Lightweight interactivity | Mobile menu, language switch, cookie consent |
| johannschopplich/kirby-helpers | 6.7.1 | Vite-Kirby bridge + SEO utilities | Provides vite()->js() / vite()->css() helpers, auto dev/prod switching |

### Supporting (Phase 1 only)

| Library | Version | Purpose | When to Use |
|---------|---------|---------|-------------|
| Node.js | 22.16.0 (available locally) | Vite and frontend tooling runtime | Development only |
| npm | 10.9.2 (available locally) | JS package management | Development only |

### Alternatives Considered

None for Phase 1 -- all choices are locked decisions from stack research.

**Installation:**
```bash
# PHP / Kirby
composer create-project getkirby/plainkit portavecia
cd portavecia
composer require johannschopplich/kirby-helpers

# Frontend
npm init -y
npm install -D vite @tailwindcss/vite @tailwindcss/typography
npm install alpinejs
```

## Architecture Patterns

### Recommended Project Structure (Phase 1 scope)
```
portavecia/
  content/                    # Kirby content (GITIGNORED)
    site.it.txt               # Global site settings IT
    site.en.txt               # Global site settings EN
    1_home/
      home.it.txt
      home.en.txt
    error/
      error.it.txt
      error.en.txt
  kirby/                      # Kirby core (Composer-managed)
  site/
    blueprints/
      site.yml                # Global fields: logo, phone, whatsapp, address, hours, social
      pages/
        default.yml           # Fallback blueprint
        home.yml              # Minimal for Phase 1
    config/
      config.php              # Languages enabled, kirby-helpers vite config
    controllers/
      site.php                # Global data (hours, contact, social) for all templates
    languages/
      it.php                  # Default language + UI translations
      en.php                  # Secondary language + UI translations
    plugins/                  # Composer-managed plugins
    snippets/
      layout/
        header.php            # <head>, sticky nav, language switch
        footer.php            # Contacts, hours, social, copyright
      components/
        language-switch.php   # IT/EN toggle
        cookie-banner.php     # GDPR cookie consent banner
    templates/
      default.php             # Base template using header/footer snippets
      home.php                # Placeholder for Phase 1
  src/                        # Vite source files
    css/
      main.css                # Tailwind imports + custom theme
    js/
      main.js                 # Alpine.js init
      cookie-consent.js       # Cookie consent Alpine component
  dist/                       # Vite build output (GITIGNORED)
  package.json
  composer.json
  vite.config.js
  .gitignore
  .htaccess
  index.php
```

### Pattern 1: Vite + kirby-helpers Integration
**What:** kirby-helpers auto-detects dev vs production mode based on manifest.json presence.
**When to use:** Every template that loads CSS/JS.
**Example:**
```php
<!-- In site/snippets/layout/header.php -->
<!DOCTYPE html>
<html lang="<?= $kirby->language()->code() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page->title() ?> | <?= $site->title() ?></title>
  <?= vite()->css('src/js/main.js') ?>
</head>
```
```php
<!-- In site/snippets/layout/footer.php, before </body> -->
  <?= vite()->js('src/js/main.js') ?>
</body>
</html>
```
Source: [kirby-helpers Vite docs](https://github.com/johannschopplich/kirby-helpers/blob/main/docs/vite.md)

### Pattern 2: Kirby Multilingual Language Files
**What:** Define languages with translations array for t() helper.
**When to use:** Every UI string that appears in templates/snippets.
**Example:**
```php
// site/languages/it.php
return [
    'code' => 'it',
    'default' => true,
    'direction' => 'ltr',
    'locale' => 'it_IT.utf8',
    'name' => 'Italiano',
    'url' => '/',
    'translations' => [
        'nav.home' => 'Home',
        'nav.about' => 'Chi Siamo',
        'nav.menu' => 'Cucina',
        'nav.wines' => 'Vini',
        'nav.gallery' => 'Galleria',
        'nav.events' => 'Eventi',
        'nav.contact' => 'Contatti',
        'footer.hours' => 'Orari',
        'footer.follow' => 'Seguici',
        'cookie.message' => 'Utilizziamo cookie tecnici necessari e, con il tuo consenso, cookie analitici e di terze parti.',
        'cookie.accept' => 'Accetta tutto',
        'cookie.reject' => 'Rifiuta tutto',
        'cookie.customize' => 'Personalizza',
        'cookie.save' => 'Salva preferenze',
        'cookie.technical' => 'Cookie tecnici',
        'cookie.analytics' => 'Cookie analitici',
        'cookie.thirdparty' => 'Cookie di terze parti',
        'cookie.always_active' => 'Sempre attivi',
        'cookie.back' => 'Indietro',
        'cookie.policy_link' => 'Cookie Policy',
    ],
];
```
```php
// site/languages/en.php
return [
    'code' => 'en',
    'default' => false,
    'direction' => 'ltr',
    'locale' => 'en_US.utf8',
    'name' => 'English',
    'translations' => [
        'nav.home' => 'Home',
        'nav.about' => 'About Us',
        'nav.menu' => 'Kitchen',
        'nav.wines' => 'Wines',
        'nav.gallery' => 'Gallery',
        'nav.events' => 'Events',
        'nav.contact' => 'Contact',
        'footer.hours' => 'Hours',
        'footer.follow' => 'Follow Us',
        'cookie.message' => 'We use necessary technical cookies and, with your consent, analytics and third-party cookies.',
        'cookie.accept' => 'Accept all',
        'cookie.reject' => 'Reject all',
        'cookie.customize' => 'Customize',
        'cookie.save' => 'Save preferences',
        'cookie.technical' => 'Technical cookies',
        'cookie.analytics' => 'Analytics cookies',
        'cookie.thirdparty' => 'Third-party cookies',
        'cookie.always_active' => 'Always active',
        'cookie.back' => 'Back',
        'cookie.policy_link' => 'Cookie Policy',
    ],
];
```
Source: [Kirby Custom Language Variables](https://getkirby.com/docs/guide/languages/custom-language-variables)

### Pattern 3: Language Switcher Snippet
**What:** Links to the same page in the other language using $page->url($language->code()).
**When to use:** In header, visible on every page.
**Example:**
```php
<!-- site/snippets/components/language-switch.php -->
<nav class="language-switch" aria-label="Language">
  <?php foreach ($kirby->languages() as $language): ?>
    <a href="<?= $page->url($language->code()) ?>"
       hreflang="<?= $language->code() ?>"
       <?php e($kirby->language() == $language, 'aria-current="true"') ?>
       class="<?php e($kirby->language() == $language, 'active') ?>">
      <?= strtoupper($language->code()) ?>
    </a>
  <?php endforeach ?>
</nav>
```
Source: [Kirby Switching Languages](https://getkirby.com/docs/guide/languages/switching-languages)

### Pattern 4: Site Controller for Global Data
**What:** Provide shared data (hours, contact, social) to all templates via site.php controller.
**When to use:** Data that appears in header/footer on every page.
**Example:**
```php
// site/controllers/site.php
return function ($site) {
    return [
        'phone'    => $site->phone()->value(),
        'whatsapp' => $site->whatsapp()->value(),
        'address'  => $site->address()->value(),
        'hours'    => $site->hours()->toStructure(),
        'social'   => $site->social()->toStructure(),
    ];
};
```
Source: [Kirby Controllers Guide](https://getkirby.com/docs/guide/templates/controllers)

### Pattern 5: Vite Config for Kirby
**What:** Minimal vite.config.js with manifest generation and Tailwind plugin.
**Example:**
```javascript
// vite.config.js
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [tailwindcss()],
  build: {
    manifest: true,
    outDir: 'dist',
    rollupOptions: {
      input: 'src/js/main.js',
    },
  },
  server: {
    port: 5173,
    strictPort: true,
  },
})
```
Source: [kirby-helpers Vite docs](https://github.com/johannschopplich/kirby-helpers/blob/main/docs/vite.md)

### Pattern 6: Tailwind CSS 4 Entry Point
**What:** CSS-first configuration using @import and @theme directives.
**Example:**
```css
/* src/css/main.css */
@import "tailwindcss";

@theme {
  /* Candore-inspired palette */
  --color-primary: oklch(0.72 0.1 75);       /* Warm gold */
  --color-primary-dark: oklch(0.62 0.1 75);  /* Darker gold */
  --color-dark: oklch(0.15 0 0);             /* Near-black */
  --color-light: oklch(0.96 0.01 80);        /* Warm off-white */

  --font-heading: 'Playfair Display', serif;
  --font-body: 'Raleway', sans-serif;
}
```
Source: [Tailwind CSS v4 docs](https://tailwindcss.com/docs)

### Anti-Patterns to Avoid
- **Hardcoded text in templates:** Use `t('key')` for ALL UI strings. Never write literal Italian/English in PHP files.
- **Logic in templates:** Keep queries and data manipulation in controllers. Templates only loop, output, and include snippets.
- **Single language first:** Never plan to "add English later." Multilingual must be enabled before any content file is created.
- **content/ in git:** Add to .gitignore from the very first commit. Production Panel edits must never collide with git deploys.

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Vite dev/prod asset switching | Custom manifest parser | kirby-helpers vite() helpers | Handles HMR injection, manifest reading, dev server proxy automatically |
| CSS utility framework | Custom CSS architecture | Tailwind CSS 4 via @tailwindcss/vite | 7+ page layouts benefit from utility-first approach; automatic content detection |
| Cookie consent system | Build from scratch | Adapt tecnostudio reference implementation | Production-proven, Garante Privacy 2021 compliant, 113 lines of Alpine.js |
| Language routing | Custom URL rewriting | Kirby built-in multilingual system | Handles URL prefixes, content file mapping, Panel language tabs automatically |
| Responsive images | Custom srcset generation | Kirby built-in thumb() + srcset() | Built into Kirby core, handles resize and format conversion |

## Cookie Consent Implementation Guide

The tecnostudio project provides a complete reference implementation that should be adapted (not copied verbatim) for Porta Vecia.

### Architecture
- **Alpine.js component** (`cookieConsent`): manages banner state, consent storage, GA4 loading, third-party event dispatch
- **PHP snippet** (`cookie-banner.php`): banner UI with Tailwind classes
- **Cookie policy page**: required legal content

### Key Compliance Points (Garante Privacy 2021)
1. **Preventive blocking**: GA4 and Google Maps scripts load ONLY after explicit consent
2. **Equal-weight buttons**: Accept/Reject/Customize must have equal visual prominence
3. **Granular categories**: Technical (always on), Analytics (opt-in), Third-party (opt-in)
4. **180-day cookie expiry**: Consent cookie lasts 6 months per Garante guidelines
5. **Click-to-load for maps**: Google Maps shows placeholder until third-party consent is given
6. **Custom events**: `cookie:thirdparty-accepted` / `cookie:thirdparty-refused` for inter-component communication

### Adaptation Needed for Porta Vecia
- Replace all hardcoded Italian strings with `t()` calls for bilingual support
- Update GA4 measurement ID field to use Porta Vecia's site blueprint
- Adapt Tailwind classes to match Porta Vecia's design tokens (Candore-inspired palette)
- Add cookie policy page content in both IT and EN
- Add "Preferenze cookie" / "Cookie preferences" link in footer

### Reference Files
- `C:\Users\boxwe\Documents\GitHub\tecnostudio\src\js\cookie-consent.js` (113 lines)
- `C:\Users\boxwe\Documents\GitHub\tecnostudio\site\snippets\components\cookie-banner.php` (100 lines)
- `C:\Users\boxwe\Documents\GitHub\tecnostudio\content\cookie-policy\default.it.txt`

## Candore Design Reference

Analysis of the Candore template (https://duruthemes.com/demo/html/candore/demo1/) reveals:

### Design Tokens to Extract
- **Dark backgrounds** with warm off-white text: near-black (#1a1a1a) + off-white (#f5f0eb)
- **Gold accent color**: warm gold for CTAs, links, decorative elements
- **Serif headings**: Playfair Display or similar elegant serif
- **Sans-serif body**: Raleway or similar clean sans-serif
- **Generous spacing**: large section padding (6rem+), breathing room

### Header Pattern
- Logo centered or left-aligned
- Horizontal navigation links
- Language selector (EN/DE in Candore)
- Sticky behavior on scroll
- Transparent on hero, solid on scroll (optional -- can simplify for Phase 1)

### Footer Pattern
- About Us column
- Contact information (address, phone, email)
- Opening hours
- Social media links
- Copyright line

### Mobile Pattern
- Hamburger menu toggle
- Full-screen or slide-out mobile navigation
- Language switch remains accessible

## Common Pitfalls

### Pitfall 1: Multilingual Not Enabled from First Commit
**What goes wrong:** Building content structure in single-language mode, then enabling multilingual later causes Kirby to rename ALL content files (adding language extensions), breaking existing references.
**Why it happens:** Developer thinks "I'll add English later."
**How to avoid:** Enable multilingual in config.php and create both language files BEFORE creating any content. This is a locked decision in STATE.md.
**Warning signs:** If site/languages/ folder is empty or missing.

### Pitfall 2: content/ Tracked in Git
**What goes wrong:** Panel edits on production overwritten by git deploy; merge conflicts in content .txt files.
**Why it happens:** Developer does `git add .` without checking .gitignore.
**How to avoid:** Add content/ to .gitignore in the very first commit. Seed initial content separately. This is a locked decision in STATE.md.
**Warning signs:** `git status` shows .txt files in content/.

### Pitfall 3: Vite Dev/Prod Mode Mismatch
**What goes wrong:** Frontend works with `npm run dev` but breaks in production because manifest.json is missing or asset paths are wrong.
**Why it happens:** Developer never tests `npm run build` locally.
**How to avoid:** The `npm run dev` script should delete dist/ folder first (`rm -rf dist && vite`) so kirby-helpers correctly detects dev mode. Test `npm run build` before any deploy.
**Warning signs:** Missing dist/manifest.json after build; broken CSS/JS in production.

### Pitfall 4: Cookie Banner Text Not Bilingual
**What goes wrong:** Cookie banner shows Italian text even when user is on the English version of the site.
**Why it happens:** Copying tecnostudio implementation verbatim without adapting for multilingual.
**How to avoid:** All cookie banner text must use Kirby `t()` helper in the PHP snippet, not hardcoded strings. The Alpine.js component itself is language-agnostic (it handles state/logic); the PHP snippet handles display text.
**Warning signs:** Switch to English and check cookie banner text.

### Pitfall 5: Tailwind CSS 4 Config Confusion
**What goes wrong:** Developer creates tailwind.config.js (v3 pattern) instead of using CSS-first @theme directive (v4 pattern).
**Why it happens:** Most tutorials and AI training data still reference Tailwind v3 configuration.
**How to avoid:** Tailwind 4 uses CSS @import "tailwindcss" + @theme directive. No JS config file. Use @tailwindcss/vite plugin, NOT postcss + tailwindcss CLI.
**Warning signs:** If tailwind.config.js exists in the project root, you are using the wrong approach.

### Pitfall 6: PHP Version Mismatch
**What goes wrong:** Local development works on PHP 8.2 but Kirby 5.3.3 may use features from newer PHP versions, or hosting environment has older PHP.
**Why it happens:** Not verifying PHP compatibility across environments.
**How to avoid:** Local PHP is 8.2.12 which meets Kirby 5 minimum (8.2+). Confirm hosting has PHP 8.2+ before deployment.
**Warning signs:** Syntax errors or function-not-found errors that only appear in one environment.

## Code Examples

### config.php (Complete Phase 1 Configuration)
```php
<?php
// site/config/config.php
return [
    'languages' => true,
    'languages.detect' => false,

    'johannschopplich.helpers.vite' => [
        'server' => [
            'port' => 5173,
            'https' => false,
        ],
        'build' => [
            'outDir' => 'dist',
        ],
    ],
];
```
Source: [Kirby Languages](https://getkirby.com/docs/guide/languages), [kirby-helpers docs](https://github.com/johannschopplich/kirby-helpers)

### site.yml Blueprint (Global Fields)
```yaml
# site/blueprints/site.yml
title: Porta Vecia
tabs:
  content:
    label: Contenuto
    fields:
      phone:
        label: Telefono
        type: tel
        translate: false
      whatsapp:
        label: WhatsApp
        type: tel
        translate: false
      email:
        label: Email
        type: email
        translate: false
      address:
        label: Indirizzo
        type: textarea
        translate: false
      ga4MeasurementId:
        label: GA4 Measurement ID
        type: text
        translate: false
        help: "Es: G-XXXXXXXXXX"
  hours:
    label: Orari
    fields:
      hours:
        label: Orari di apertura
        type: structure
        fields:
          day:
            label: Giorno
            type: text
            width: 1/2
          time:
            label: Orario
            type: text
            width: 1/2
  social:
    label: Social
    fields:
      social:
        label: Social Media
        type: structure
        fields:
          platform:
            label: Piattaforma
            type: select
            options:
              instagram: Instagram
              facebook: Facebook
              tripadvisor: TripAdvisor
            width: 1/2
          url:
            label: URL
            type: url
            width: 1/2
```

### main.js (Alpine.js Entry Point)
```javascript
// src/js/main.js
import Alpine from 'alpinejs'
import '../css/main.css'
import './cookie-consent.js'

window.Alpine = Alpine
Alpine.start()
```

### package.json Scripts
```json
{
  "scripts": {
    "dev": "rm -rf dist && vite",
    "build": "vite build",
    "preview": "vite preview"
  }
}
```
Note: On Windows, use `rimraf dist && vite` or cross-env compatible deletion. Alternatively, use a simple node script or adjust the rm command for cross-platform compatibility.

### .gitignore (Critical Phase 1 File)
```
/content/
/dist/
/media/
/node_modules/
/vendor/
.DS_Store
Thumbs.db
.env
```

## State of the Art

| Old Approach | Current Approach | When Changed | Impact |
|--------------|------------------|--------------|--------|
| Tailwind v3 JS config file | Tailwind v4 CSS-first @theme directive | Jan 2025 | No tailwind.config.js needed; use @import "tailwindcss" in CSS |
| PostCSS + tailwindcss plugin | @tailwindcss/vite native Vite plugin | Jan 2025 | Simpler config, better performance, automatic content detection |
| kirby-vite separate plugin | kirby-helpers (includes vite + SEO) | 2024 | One plugin instead of two; kirby-vite is deprecated |
| Manual dev/prod asset switching | kirby-helpers manifest detection | 2024 | Automatic based on dist/manifest.json presence |

## Open Questions

1. **Google Fonts loading strategy**
   - What we know: Candore uses Playfair Display + Raleway. These are Google Fonts.
   - What's unclear: Self-host via @fontsource packages (no external requests, GDPR-friendly) or load from Google Fonts CDN?
   - Recommendation: Self-host via @fontsource to avoid GDPR issues with Google Fonts (DSGVO precedent). Install `@fontsource/playfair-display` and `@fontsource/raleway` via npm.

2. **Logo asset**
   - What we know: Logo is "provided by client" per constraints.
   - What's unclear: Whether the logo file is available yet.
   - Recommendation: Use a text placeholder ("Porta Vecia") in Phase 1 header; swap for actual logo asset when available.

3. **Windows rm -rf compatibility**
   - What we know: `rm -rf dist` in npm scripts does not work natively on Windows cmd.
   - What's unclear: Whether the developer uses Git Bash (which supports rm) or cmd/PowerShell.
   - Recommendation: Use `rimraf` package (`npm install -D rimraf`) for cross-platform dist cleanup, or rely on Git Bash which is available (verified: git version 2.50.0.windows.1).

## Environment Availability

| Dependency | Required By | Available | Version | Fallback |
|------------|------------|-----------|---------|----------|
| PHP | Kirby 5 runtime | Yes | 8.2.12 | -- (meets minimum 8.2+) |
| Node.js | Vite, Tailwind, Alpine | Yes | 22.16.0 | -- |
| npm | JS package management | Yes | 10.9.2 | -- |
| Composer | PHP dependency management | Yes | 2.4.4 | -- |
| Git | Version control | Yes | 2.50.0 | -- |

**Missing dependencies with no fallback:** None.

**Missing dependencies with fallback:** None.

**Note:** PHP 8.2.12 is the minimum supported by Kirby 5. It works but PHP 8.3+ would be preferred for longer support (8.2 EOL Dec 2025 -- already past). For local development this is acceptable; production hosting should target PHP 8.3+.

## Sources

### Primary (HIGH confidence)
- [Kirby Multi-language Guide](https://getkirby.com/docs/guide/languages) -- language configuration, URL routing, t() helper
- [Kirby Switching Languages](https://getkirby.com/docs/guide/languages/switching-languages) -- language switcher snippet pattern
- [Kirby Custom Language Variables](https://getkirby.com/docs/guide/languages/custom-language-variables) -- translations array in language files
- [kirby-helpers GitHub](https://github.com/johannschopplich/kirby-helpers) -- v6.7.1, Vite integration docs
- [kirby-helpers Vite docs](https://github.com/johannschopplich/kirby-helpers/blob/main/docs/vite.md) -- vite() helpers, config.php settings, manifest detection
- [Tailwind CSS v4 docs](https://tailwindcss.com/docs) -- @tailwindcss/vite plugin setup, CSS-first config
- [npm registry](https://www.npmjs.com/) -- verified versions: vite 8.0.7, @tailwindcss/vite 4.2.2, alpinejs 3.15.11, @tailwindcss/typography 0.5.19
- Tecnostudio reference implementation (local files) -- cookie consent Alpine.js component, banner snippet, cookie policy content

### Secondary (MEDIUM confidence)
- [Candore Template Demo](https://duruthemes.com/demo/html/candore/demo1/) -- design reference analysis (WebFetch)
- [Kirby Controllers Guide](https://getkirby.com/docs/guide/templates/controllers) -- site.php controller pattern

## Metadata

**Confidence breakdown:**
- Standard stack: HIGH -- all versions verified against npm registry and official docs
- Architecture: HIGH -- Kirby conventions well-documented; kirby-helpers Vite integration verified
- Multilingual: HIGH -- official Kirby documentation with code examples
- Cookie consent: HIGH -- production reference implementation available locally
- Design (Candore-inspired): MEDIUM -- template analyzed via WebFetch; design tokens are interpretive

**Research date:** 2026-04-08
**Valid until:** 2026-05-08 (stable stack, no fast-moving dependencies)
