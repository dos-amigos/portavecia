# Technology Stack

**Project:** Porta Vecia (Wine Bar / Enoteca Website)
**Researched:** 2026-04-08

## Recommended Stack

### Core CMS

| Technology | Version | Purpose | Why | Confidence |
|------------|---------|---------|-----|------------|
| Kirby CMS | 5.x (latest 5.3.3) | Content management, Panel admin | Client requirement. File-based (no DB), intuitive Panel for non-technical editors, built-in multilingual support. Perfect for a content-managed restaurant site. | HIGH |
| PHP | 8.3 or 8.4 | Runtime | Kirby 5 requires PHP 8.2+. Target 8.3+ for best performance and long-term support (8.3 EOL Dec 2027, 8.4 EOL Nov 2028). | HIGH |
| Composer | 2.x | Dependency management | Standard PHP dependency manager. Required for Kirby installation and plugin management. | HIGH |

### Frontend Build Tooling

| Technology | Version | Purpose | Why | Confidence |
|------------|---------|---------|-----|------------|
| Vite | 8.x (latest 8.0.7) | Build tool, dev server, HMR | Industry standard. Lightning-fast HMR, native ES modules, handles CSS/JS bundling. Vite 8 uses Rolldown for faster builds. | HIGH |
| johannschopplich/kirby-helpers | latest | Vite-Kirby bridge, SEO utilities | Replaces the abandoned `kirby-vite` package. Provides `vite()->js()` / `vite()->css()` helpers, auto-switches between dev server and production manifest. Also includes SEO meta, sitemap, and redirect utilities -- covers multiple needs in one plugin. | HIGH |

### CSS / Styling

| Technology | Version | Purpose | Why | Confidence |
|------------|---------|---------|-----|------------|
| Tailwind CSS | 4.x (latest 4.2.x) | Utility-first CSS framework | Rapid prototyping of the Candore-inspired design. CSS-first config (no JS config file in v4), OKLCH colors for richer palette, automatic content detection. The restaurant/enoteca pages (menu, wine cards, gallery grids) benefit from utility classes for fast layout iteration. | HIGH |
| @tailwindcss/typography | 4.x | Prose styling for CMS content | Kirby's rich text fields output unstyled HTML. This plugin applies elegant typographic defaults to `.prose` containers -- essential for menu descriptions, about page content, etc. | HIGH |

**Why Tailwind over vanilla CSS:** This project has 7+ unique page layouts (home, about, menu, wine, gallery, events, contact) plus bilingual variants. Tailwind's utility approach speeds up building these varied layouts without maintaining a large custom CSS architecture. The Candore-inspired design can be systematized through Tailwind's `@theme` directive for consistent spacing, colors, and typography.

**Why NOT Bootstrap:** Bootstrap's opinionated component design fights against custom aesthetic goals. The Candore template has a distinctive elegant feel that would require overriding most Bootstrap defaults -- more work than building with utilities.

### JavaScript / Interactivity

| Technology | Version | Purpose | Why | Confidence |
|------------|---------|---------|-----|------------|
| Alpine.js | 3.x | Lightweight reactive interactivity | 15KB minified. Perfect for mobile menu toggle, language switcher, accordion menus, gallery filtering -- all without a heavy SPA framework. Pairs naturally with server-rendered Kirby templates. Declarative HTML directives (`x-data`, `x-show`, `x-on`) are readable and maintainable. | HIGH |
| GSAP | 3.x (free tier) | Scroll animations, entrance effects | The Candore template uses smooth scroll-triggered animations (fade-ins, parallels, staggered reveals). GSAP + ScrollTrigger is the gold standard for this. Now 100% free including all plugins (ScrollTrigger, ScrollSmoother). Keep usage restrained -- elegant subtle animations only. | MEDIUM |
| GLightbox | 3.x | Lightbox for gallery page | Pure JS, no jQuery dependency, mobile-friendly, supports images/video. Lightweight alternative to PhotoSwipe with simpler API. Matches the Candore gallery lightbox pattern. | MEDIUM |
| Swiper | 11.x | Touch-friendly slider/carousel | For hero slideshow and wine/menu card carousels. Most popular touch slider, excellent mobile support, no jQuery. | MEDIUM |

**Why NOT a full SPA framework (Vue, React):** This is a content-driven multi-page site. Server-rendered Kirby templates with Alpine.js sprinkles provide the right interactivity level. A SPA framework would add unnecessary complexity, hurt SEO, and complicate the Kirby Panel integration.

### Kirby Plugins

| Plugin | Purpose | Why This One | Confidence |
|--------|---------|--------------|------------|
| johannschopplich/kirby-helpers | Vite integration + SEO meta + sitemap + redirects | All-in-one: covers Vite bridge AND SEO needs. Actively maintained, Kirby 5 compatible. Eliminates need for separate SEO plugin. | HIGH |
| tobimori/kirby-seo | SEO toolkit (meta cascade, Open Graph, Schema.org, robots, sitemap) | If kirby-helpers SEO features prove insufficient. Full-featured SEO with Panel UI for per-page meta editing. Multi-lang sitemap support. Last updated Mar 2026. Use as fallback only if kirby-helpers doesn't cover all SEO needs. | MEDIUM |

**Minimal plugin approach:** Kirby's built-in features (multilingual, image thumbs, Panel, blueprints) cover most needs. Avoid plugin bloat -- each plugin is a maintenance dependency.

### Image Handling

| Technology | Purpose | Configuration | Confidence |
|------------|---------|---------------|------------|
| Kirby built-in thumbs | On-the-fly image resizing | Async thumb generation, configure srcset presets for responsive images | HIGH |
| WebP/AVIF conversion | Modern image formats | Kirby's `thumb()` and `srcset()` support `format: 'webp'` and `format: 'avif'` natively | HIGH |
| Lazy loading | Performance | Native `loading="lazy"` attribute on images, Kirby cookbook pattern | HIGH |

**No external image CDN needed.** Kirby's built-in thumb system handles resize, format conversion, and srcset generation. Configure presets in `config.php` for consistent responsive images across the site.

### Multilingual Setup

| Component | Approach | Confidence |
|-----------|----------|------------|
| Language config | Italian (default) + English (secondary) in `site/languages/` | HIGH |
| URL structure | `/it/pagina` and `/en/page` with language prefix | HIGH |
| Content files | `*.it.txt` (default) and `*.en.txt` (translations) | HIGH |
| Language switcher | Alpine.js component using `$kirby->languages()` | HIGH |
| Panel translation | Built-in -- editors see language tabs per page | HIGH |

**Start bilingual from day 1.** Kirby's multi-language is a config toggle, but retrofitting content structure is painful. Define both languages before creating any content.

### Infrastructure / Deployment

| Technology | Purpose | Why | Confidence |
|------------|---------|-----|------------|
| Shared hosting (PHP 8.3+) | Production hosting | Kirby needs only PHP + Apache/Nginx. No database. Shared hosting is cost-effective for a local business site. Providers: Hetzner, SiteGround, or any PHP 8.3+ host with SSH access. | HIGH |
| Git + SFTP/rsync | Deployment | Simple deployment: `git pull` on server or rsync from local. No CI/CD pipeline needed for a site this size. Keep `content/` out of git (managed via Panel in production). | HIGH |
| Apache + mod_rewrite | Web server | Kirby ships with `.htaccess` for Apache. Most shared hosts run Apache. Public folder setup for security. | HIGH |
| Let's Encrypt | SSL | Free HTTPS. Most hosts auto-provision. Required for SEO and trust. | HIGH |

### Development Environment

| Tool | Purpose | Why |
|------|---------|-----|
| PHP built-in server or Laravel Valet | Local PHP server | `php -S localhost:8000 kirby/router.php` for quick start. Valet for multi-site dev. |
| Node.js 20+ | Vite and frontend tooling | LTS version for Vite 8, Tailwind 4, PostCSS |
| Composer 2.x | PHP dependency management | Install Kirby + plugins |
| npm | JS dependency management | Install Vite, Tailwind, Alpine, GSAP, etc. |

## Project Initialization

```bash
# 1. Create project from Kirby plainkit
composer create-project getkirby/plainkit portavecia

# 2. Install Kirby plugins
cd portavecia
composer require johannschopplich/kirby-helpers

# 3. Initialize frontend tooling
npm init -y
npm install -D vite tailwindcss @tailwindcss/typography
npm install alpinejs gsap glightbox swiper
```

### Directory Structure

```
portavecia/
  content/            # Kirby content (text files, uploaded media)
  kirby/              # Kirby core (managed by Composer)
  site/
    blueprints/       # Panel field definitions per page type
    config/           # config.php (languages, thumbs, etc.)
    languages/        # it.php, en.php
    plugins/          # Kirby plugins (Composer-managed)
    snippets/         # Reusable template partials (header, footer, etc.)
    templates/        # Page templates (home.php, menu.php, etc.)
  src/                # Frontend source (Vite entry point)
    css/
      main.css        # Tailwind imports + custom styles
    js/
      main.js         # Alpine.js init, GSAP animations, etc.
  public/             # Vite build output (production assets)
  package.json
  composer.json
  vite.config.js
```

## Alternatives Considered

| Category | Recommended | Alternative | Why Not |
|----------|-------------|-------------|---------|
| CSS Framework | Tailwind CSS 4 | Bootstrap 5 | Bootstrap's component-heavy approach fights custom design. Overriding defaults is more work than building with utilities. |
| CSS Framework | Tailwind CSS 4 | Vanilla CSS / SCSS | 7+ page layouts would require significant custom CSS architecture. Tailwind is faster for this scope. |
| JS Interactivity | Alpine.js | Vue.js / Petite-Vue | Overkill for menu toggles and language switches. Alpine is purpose-built for this use case. |
| Build Tool | Vite 8 | Webpack | Vite is faster, simpler config, native ES modules. No reason to use Webpack for a new project in 2026. |
| Vite Integration | kirby-helpers | arnoson/kirby-vite | kirby-helpers bundles Vite integration + SEO utilities. One plugin instead of two. |
| SEO | kirby-helpers (built-in) | tobimori/kirby-seo | Start with kirby-helpers. Only add dedicated SEO plugin if meta cascade / Schema.org needs exceed built-in features. |
| Lightbox | GLightbox | PhotoSwipe 5 | GLightbox has simpler API, lighter weight. PhotoSwipe is more powerful but overkill for a gallery page. |
| Animation | GSAP | CSS-only animations | Candore-style scroll-triggered reveals are easier to orchestrate with GSAP ScrollTrigger than pure CSS. |
| CMS | Kirby 5 | WordPress | Client requirement is Kirby. Also: Kirby is cleaner, no database, better DX, less security surface. |

## Version Pinning Summary

```json
{
  "php": ">=8.3",
  "getkirby/cms": "^5.0",
  "johannschopplich/kirby-helpers": "^3.0",
  "vite": "^8.0",
  "tailwindcss": "^4.0",
  "@tailwindcss/typography": "^0.5",
  "alpinejs": "^3.0",
  "gsap": "^3.0",
  "glightbox": "^3.0",
  "swiper": "^11.0"
}
```

## Sources

- [Kirby CMS Requirements](https://getkirby.com/docs/reference/system/requirements) - PHP version requirements
- [Kirby 5 Release](https://getkirby.com/releases/5) - Kirby 5 features and release info
- [Kirby Multi-language Guide](https://getkirby.com/docs/guide/languages) - Official multilingual documentation
- [Kirby Responsive Images Cookbook](https://getkirby.com/docs/cookbook/performance/responsive-images) - Srcset and thumb configuration
- [Kirby meets Tailwind CSS](https://getkirby.com/docs/cookbook/frontend/kirby-meets-tailwindcss) - Official Tailwind integration guide
- [johannschopplich/kirby-helpers](https://github.com/johannschopplich/kirby-helpers) - Vite + SEO utilities plugin
- [tobimori/kirby-seo](https://github.com/tobimori/kirby-seo) - Comprehensive SEO plugin
- [Vite Releases](https://vite.dev/releases) - Vite 8 release info
- [Tailwind CSS v4.0](https://tailwindcss.com/blog/tailwindcss-v4) - Tailwind v4 features
- [Alpine.js](https://alpinejs.dev/) - Lightweight JS framework
- [GSAP](https://gsap.com/) - Animation platform (now free for all uses)
- [Kirby Deployment Best Practices](https://forum.getkirby.com/t/deployment-guidelines/30621) - Community deployment guidance
