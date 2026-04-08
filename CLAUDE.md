# Regole Tassative - Progetto Porta Vecia

Queste regole sono OBBLIGATORIE per ogni agente AI che lavora su questo progetto.

## 1. Commit frequenti e descrittivi
- Ogni modifica, anche piccola, va committata subito.
- Il messaggio di commit deve descrivere in dettaglio COSA è stato fatto e PERCHÉ.
- Non accumulare modifiche multiple in un singolo commit.

## 2. Non inventarsi nulla - Chiedere conferma
- Non prendere iniziativa su modifiche non richieste esplicitamente dall'utente.
- Per modifiche complesse o rischiose: CHIEDERE SEMPRE conferma prima di procedere.
- Non aggiungere feature, refactoring o "miglioramenti" non richiesti.

## 3. Cercare online, non fidarsi della memoria
- Per qualsiasi dubbio tecnico, best practice, o informazione non certa al 100%: CERCARE IN INTERNET.
- Per servizi esterni, API, configurazioni di terze parti: VERIFICARE SEMPRE la documentazione ufficiale online.
- Non affidarsi mai alla memoria dell'AI per informazioni che potrebbero essere obsolete o imprecise.
- Usare WebSearch/WebFetch per consultare documentazione aggiornata.

## Contesto del progetto
- **Progetto**: Sito web per l'enoteca "Porta Vecia"
- **CMS**: Kirby
- **Repository**: https://github.com/dos-amigos/portavecia

<!-- GSD:project-start source:PROJECT.md -->
## Project

**Porta Vecia**

Sito web multi-pagina per l'enoteca "Porta Vecia" di Este (PD), costruito con Kirby CMS. Il sito presenta un'enoteca nel centro storico di Este che offre vini di qualità e autentica cucina cinese fatta in casa — ravioli, involtini, spaghetti e altre prelibatezze preparate al momento, servite come accompagnamento all'aperitivo e per cena. Il sito è bilingue (italiano/inglese) e interamente gestibile da backend.

**Core Value:** Invitare i visitatori a scoprire Porta Vecia come esperienza unica: l'incontro tra enoteca italiana e cucina cinese autentica in un contesto storico suggestivo, con un forte invito all'aperitivo accompagnato da prelibatezze fatte in casa.

### Constraints

- **Tech stack**: Kirby CMS (PHP) — richiesto esplicitamente
- **Lingue**: Italiano + Inglese — predisposti dal giorno 1 con il sistema multilingua di Kirby
- **Brand**: Logo fornito dal cliente, resto dell'identità visiva da definire ispirandosi a Candore
- **Prenotazioni**: Solo WhatsApp/telefono, nessun servizio esterno o form
- **Hosting**: Da definire (ma Kirby richiede solo PHP, niente database)
<!-- GSD:project-end -->

<!-- GSD:stack-start source:research/STACK.md -->
## Technology Stack

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
### JavaScript / Interactivity
| Technology | Version | Purpose | Why | Confidence |
|------------|---------|---------|-----|------------|
| Alpine.js | 3.x | Lightweight reactive interactivity | 15KB minified. Perfect for mobile menu toggle, language switcher, accordion menus, gallery filtering -- all without a heavy SPA framework. Pairs naturally with server-rendered Kirby templates. Declarative HTML directives (`x-data`, `x-show`, `x-on`) are readable and maintainable. | HIGH |
| GSAP | 3.x (free tier) | Scroll animations, entrance effects | The Candore template uses smooth scroll-triggered animations (fade-ins, parallels, staggered reveals). GSAP + ScrollTrigger is the gold standard for this. Now 100% free including all plugins (ScrollTrigger, ScrollSmoother). Keep usage restrained -- elegant subtle animations only. | MEDIUM |
| GLightbox | 3.x | Lightbox for gallery page | Pure JS, no jQuery dependency, mobile-friendly, supports images/video. Lightweight alternative to PhotoSwipe with simpler API. Matches the Candore gallery lightbox pattern. | MEDIUM |
| Swiper | 11.x | Touch-friendly slider/carousel | For hero slideshow and wine/menu card carousels. Most popular touch slider, excellent mobile support, no jQuery. | MEDIUM |
### Kirby Plugins
| Plugin | Purpose | Why This One | Confidence |
|--------|---------|--------------|------------|
| johannschopplich/kirby-helpers | Vite integration + SEO meta + sitemap + redirects | All-in-one: covers Vite bridge AND SEO needs. Actively maintained, Kirby 5 compatible. Eliminates need for separate SEO plugin. | HIGH |
| tobimori/kirby-seo | SEO toolkit (meta cascade, Open Graph, Schema.org, robots, sitemap) | If kirby-helpers SEO features prove insufficient. Full-featured SEO with Panel UI for per-page meta editing. Multi-lang sitemap support. Last updated Mar 2026. Use as fallback only if kirby-helpers doesn't cover all SEO needs. | MEDIUM |
### Image Handling
| Technology | Purpose | Configuration | Confidence |
|------------|---------|---------------|------------|
| Kirby built-in thumbs | On-the-fly image resizing | Async thumb generation, configure srcset presets for responsive images | HIGH |
| WebP/AVIF conversion | Modern image formats | Kirby's `thumb()` and `srcset()` support `format: 'webp'` and `format: 'avif'` natively | HIGH |
| Lazy loading | Performance | Native `loading="lazy"` attribute on images, Kirby cookbook pattern | HIGH |
### Multilingual Setup
| Component | Approach | Confidence |
|-----------|----------|------------|
| Language config | Italian (default) + English (secondary) in `site/languages/` | HIGH |
| URL structure | `/it/pagina` and `/en/page` with language prefix | HIGH |
| Content files | `*.it.txt` (default) and `*.en.txt` (translations) | HIGH |
| Language switcher | Alpine.js component using `$kirby->languages()` | HIGH |
| Panel translation | Built-in -- editors see language tabs per page | HIGH |
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
# 1. Create project from Kirby plainkit
# 2. Install Kirby plugins
# 3. Initialize frontend tooling
### Directory Structure
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
<!-- GSD:stack-end -->

<!-- GSD:conventions-start source:CONVENTIONS.md -->
## Conventions

Conventions not yet established. Will populate as patterns emerge during development.
<!-- GSD:conventions-end -->

<!-- GSD:architecture-start source:ARCHITECTURE.md -->
## Architecture

Architecture not yet mapped. Follow existing patterns found in the codebase.
<!-- GSD:architecture-end -->

<!-- GSD:workflow-start source:GSD defaults -->
## GSD Workflow Enforcement

Before using Edit, Write, or other file-changing tools, start work through a GSD command so planning artifacts and execution context stay in sync.

Use these entry points:
- `/gsd:quick` for small fixes, doc updates, and ad-hoc tasks
- `/gsd:debug` for investigation and bug fixing
- `/gsd:execute-phase` for planned phase work

Do not make direct repo edits outside a GSD workflow unless the user explicitly asks to bypass it.
<!-- GSD:workflow-end -->

<!-- GSD:profile-start -->
## Developer Profile

> Profile not yet configured. Run `/gsd:profile-user` to generate your developer profile.
> This section is managed by `generate-claude-profile` -- do not edit manually.
<!-- GSD:profile-end -->
