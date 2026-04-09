# Phase 4: SEO and Performance - Research

**Researched:** 2026-04-09
**Domain:** Technical SEO, structured data, image performance optimization (Kirby CMS)
**Confidence:** HIGH

## Summary

Phase 4 adds technical SEO and image performance to an existing Kirby 5 multilingual site (IT/EN) with 7 pages. The project already has the `johannschopplich/kirby-helpers` plugin installed, which provides meta tag rendering (`$page->meta()->social()`, `->robots()`, `->jsonld()`), automatic sitemap generation with multilingual hreflang support, and robots.txt generation. The plugin uses a cascade system: config defaults -> page content fields -> page model `metadata()` method.

Images across all templates currently use single `thumb()` calls without srcset or WebP conversion. Kirby's built-in `$file->srcset()` method with config presets and `format: 'webp'` support makes upgrading straightforward. The `<picture>` element pattern with WebP source and fallback img is the standard approach.

**Primary recommendation:** Use kirby-helpers for all meta/sitemap/robots. Add SEO blueprint fields (description, thumbnail, customtitle) to all 7 page blueprints + site.yml. Create a reusable `responsive-image` snippet for srcset+WebP. Build JSON-LD via page model `metadata()` methods.

<user_constraints>

## User Constraints (from CONTEXT.md)

### Locked Decisions
No locked user decisions -- all technical decisions delegated to Claude's discretion.

### Claude's Discretion
- **D-01:** Meta tags strategy -- use kirby-helpers plugin SEO features for meta title, description, Open Graph per page. Add SEO tab to each page blueprint for Panel editing.
- **D-02:** Hreflang implementation -- Kirby's built-in multilingual URL handling with `<link rel="alternate" hreflang="it">` and `hreflang="en"` in header snippet.
- **D-03:** JSON-LD structured data -- LocalBusiness/Restaurant schema on homepage and contact page. Include: name, address, phone, openingHours, servesCuisine (Italian wine + Chinese cuisine), menu URL, geo coordinates. Validate with Google Rich Results Test.
- **D-04:** Sitemap -- use kirby-helpers sitemap generation for both language versions. Ensure all pages are included with correct hreflang alternates.
- **D-05:** Image optimization -- configure Kirby srcset presets (320, 640, 960, 1280, 1920), WebP conversion via `format: 'webp'` in thumb(), native `loading="lazy"` on all images except above-the-fold hero.
- **D-06:** Performance targets -- gallery and menu pages under 3 seconds on 4G. Compress hero video if present. Optimize Leaflet and GLightbox loading (already CDN-loaded on specific pages only).
- **D-07:** Robots.txt and canonical URLs -- standard setup, prevent duplicate content between language versions.

### Deferred Ideas (OUT OF SCOPE)
None -- discussion stayed within phase scope.

</user_constraints>

<phase_requirements>

## Phase Requirements

| ID | Description | Research Support |
|----|-------------|------------------|
| SEO-01 | Meta title/description per ogni pagina, editabili da backend | kirby-helpers PageMeta cascade: add `customtitle`, `description`, `thumbnail` fields to blueprints; render via `$page->meta()->social()` and `->robots()` in header snippet |
| SEO-02 | JSON-LD structured data (LocalBusiness/Restaurant) | kirby-helpers `->jsonld()` method renders `<script type="application/ld+json">` from page model `metadata()` return; Restaurant schema with servesCuisine, openingHoursSpecification, PostalAddress |
| SEO-03 | Tag hreflang per versioni IT/EN | kirby-helpers SiteMeta sitemap already includes `<xhtml:link rel="alternate" hreflang>` per language; add HTML `<link rel="alternate" hreflang>` tags in header snippet using `$kirby->languages()` loop |
| SEO-04 | Ottimizzazione immagini con srcset e lazy loading | Kirby built-in `$file->srcset()` with config presets + `format: 'webp'`; `<picture>` element with WebP source; `loading="lazy"` on all non-hero images |

</phase_requirements>

## Project Constraints (from CLAUDE.md)

- **Commit frequently**: Every change, even small, must be committed immediately with descriptive messages.
- **No initiative**: Do not make unrequested changes. Ask confirmation for complex/risky modifications.
- **Verify online**: For any technical doubt, search internet for current documentation. Do not rely on AI memory.
- **GSD Workflow**: All edits must go through GSD workflow entry points.

## Architecture Patterns

### SEO Blueprint Pattern (add to all 7 page blueprints + site.yml)

Add an `seo` tab to every page blueprint with these fields that kirby-helpers recognizes:

```yaml
# Add to each page blueprint (home.yml, about.yml, menu.yml, wines.yml, gallery.yml, events.yml, contact.yml)
seo:
  label: SEO
  fields:
    customtitle:
      label: SEO Title
      type: text
      help: "Overrides page title in <title> and Open Graph. Max 60 chars recommended."
      counter: true
      maxlength: 70
    description:
      label: Meta Description
      type: textarea
      size: small
      help: "Shown in search results. Max 160 chars recommended."
      counter: true
      maxlength: 170
    thumbnail:
      label: Social Share Image
      type: files
      query: page.images
      multiple: false
      help: "Image for Open Graph / Twitter. Recommended 1200x630px."
```

For `site.yml`, add the same fields as global fallbacks (the plugin cascades: page field -> site field -> default).

### Header Meta Tags Pattern

Update `site/snippets/layout/header.php` `<head>` section:

```php
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page->meta()->customtitle()->or($page->title()) ?> | <?= $site->title() ?></title>

  <!-- SEO meta, Open Graph, Twitter Cards -->
  <?= $page->meta()->robots() ?>
  <?= $page->meta()->social() ?>

  <!-- JSON-LD structured data -->
  <?= $page->meta()->jsonld() ?>

  <!-- Hreflang for multilingual -->
  <?php foreach ($kirby->languages() as $lang): ?>
  <link rel="alternate" hreflang="<?= $lang->code() ?>" href="<?= $page->url($lang->code()) ?>" />
  <?php endforeach ?>
  <link rel="alternate" hreflang="x-default" href="<?= $page->url($kirby->defaultLanguage()->code()) ?>" />

  <?= vite()->css('src/js/main.js') ?>
</head>
```

### JSON-LD via Page Model metadata() Method

Create page models to return structured data. The kirby-helpers plugin renders JSON-LD from the `metadata()` method:

```php
// site/models/home.php
<?php
use Kirby\Cms\Page;

class HomePage extends Page
{
    public function metadata(): array
    {
        $site = $this->site();
        return [
            'jsonld' => [
                'Restaurant' => [
                    '@type' => 'Restaurant',
                    'name' => $site->title()->value(),
                    'description' => $this->meta()->description()->value(),
                    'url' => $site->url(),
                    'telephone' => $site->phone()->value(),
                    'servesCuisine' => ['Italian Wine Bar', 'Chinese Cuisine'],
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => '...', // from site field
                        'addressLocality' => 'Este',
                        'addressRegion' => 'PD',
                        'postalCode' => '35042',
                        'addressCountry' => 'IT'
                    ],
                    'geo' => [
                        '@type' => 'GeoCoordinates',
                        'latitude' => '...', // from site field
                        'longitude' => '...'
                    ],
                    'openingHoursSpecification' => [
                        // Build from site hours structure field
                    ],
                    'menu' => $site->find('menu') ? $site->find('menu')->url() : null,
                    'priceRange' => '$$',
                ]
            ]
        ];
    }
}
```

### Responsive Image Snippet Pattern

Create a reusable snippet for responsive images with WebP:

```php
// site/snippets/components/responsive-image.php
<?php
/** @var \Kirby\Cms\File $image */
/** @var string $sizes */
/** @var string $preset - 'default', 'square', 'card' */
/** @var string $alt */
/** @var bool $lazy - default true */

$preset = $preset ?? 'default';
$lazy = $lazy ?? true;
$alt = $alt ?? $image->alt()->value() ?? '';
$sizes = $sizes ?? '100vw';
?>
<?php if ($image): ?>
<picture>
  <source
    srcset="<?= $image->srcset($preset . '-webp') ?>"
    sizes="<?= $sizes ?>"
    type="image/webp"
  >
  <img
    src="<?= $image->resize(640)->url() ?>"
    srcset="<?= $image->srcset($preset) ?>"
    sizes="<?= $sizes ?>"
    alt="<?= esc($alt) ?>"
    width="<?= $image->width() ?>"
    height="<?= $image->height() ?>"
    <?php if ($lazy): ?>loading="lazy" decoding="async"<?php endif ?>
    class="<?= $class ?? '' ?>"
  >
</picture>
<?php endif ?>
```

### Srcset Config Presets

```php
// In site/config/config.php thumbs section
'thumbs' => [
    'srcsets' => [
        'default' => [
            '320w'  => ['width' => 320, 'quality' => 80],
            '640w'  => ['width' => 640, 'quality' => 80],
            '960w'  => ['width' => 960, 'quality' => 80],
            '1280w' => ['width' => 1280, 'quality' => 80],
            '1920w' => ['width' => 1920, 'quality' => 80],
        ],
        'default-webp' => [
            '320w'  => ['width' => 320, 'format' => 'webp', 'quality' => 80],
            '640w'  => ['width' => 640, 'format' => 'webp', 'quality' => 80],
            '960w'  => ['width' => 960, 'format' => 'webp', 'quality' => 80],
            '1280w' => ['width' => 1280, 'format' => 'webp', 'quality' => 80],
            '1920w' => ['width' => 1920, 'format' => 'webp', 'quality' => 80],
        ],
        'card' => [
            '300w'  => ['width' => 300, 'height' => 300, 'crop' => 'center', 'quality' => 80],
            '600w'  => ['width' => 600, 'height' => 600, 'crop' => 'center', 'quality' => 80],
        ],
        'card-webp' => [
            '300w'  => ['width' => 300, 'height' => 300, 'crop' => 'center', 'format' => 'webp', 'quality' => 80],
            '600w'  => ['width' => 600, 'height' => 600, 'crop' => 'center', 'format' => 'webp', 'quality' => 80],
        ],
        'gallery' => [
            '400w'  => ['width' => 400, 'quality' => 75],
            '600w'  => ['width' => 600, 'quality' => 75],
            '900w'  => ['width' => 900, 'quality' => 75],
        ],
        'gallery-webp' => [
            '400w'  => ['width' => 400, 'format' => 'webp', 'quality' => 75],
            '600w'  => ['width' => 600, 'format' => 'webp', 'quality' => 75],
            '900w'  => ['width' => 900, 'format' => 'webp', 'quality' => 75],
        ],
    ],
],
```

### Sitemap and Robots Config

```php
// In site/config/config.php
'johannschopplich.helpers.sitemap.enabled' => true,
'johannschopplich.helpers.robots.enabled' => true,
```

The kirby-helpers SiteMeta class automatically:
- Generates sitemap.xml with all pages, `<lastmod>`, `<priority>`
- Adds `<xhtml:link rel="alternate" hreflang>` for each language in sitemap
- Adds `hreflang="x-default"` pointing to default language URL
- Generates robots.txt with `Allow: /` and `Sitemap:` reference
- Respects blueprint `options.sitemap: false` to exclude pages
- Supports template/page exclusion via config options

### Anti-Patterns to Avoid
- **Duplicate title tags:** The current header has `<title><?= $page->title() ?> | <?= $site->title() ?></title>`. Replace with customtitle-aware version. Do NOT output two `<title>` tags.
- **Calling thumb() multiple times for same params:** Gallery template calls `$image->thumb(['width' => 600, 'quality' => 80])` three times per image. Cache in a variable.
- **Missing width/height on images:** Causes layout shift (CLS). Always include width/height attributes.
- **Lazy loading hero images:** Above-the-fold images should NOT have `loading="lazy"` -- it delays LCP.

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Meta tags / OG / Twitter | Custom meta tag generation | kirby-helpers `$page->meta()->social()` + `->robots()` | Plugin handles cascade, fallbacks, image resizing, all edge cases |
| Sitemap XML | Manual sitemap generation | kirby-helpers `sitemap.enabled => true` | Plugin handles multilingual hreflang, excludes, lastmod, priority |
| Robots.txt | Manual robots.txt file | kirby-helpers `robots.enabled => true` | Plugin generates correct format with sitemap reference |
| Responsive images | Manual srcset string building | Kirby `$file->srcset()` with config presets | Native method handles width descriptors, format conversion |
| JSON-LD output | Manual `<script>` tag construction | kirby-helpers `$page->meta()->jsonld()` | Plugin handles JSON encoding, debug formatting, context/type |

## Common Pitfalls

### Pitfall 1: Opening Hours Format in JSON-LD
**What goes wrong:** Using wrong format for `openingHoursSpecification` causes Google validation errors.
**Why it happens:** Multiple Schema.org formats exist (`openingHours` simple string vs `openingHoursSpecification` objects).
**How to avoid:** Use `openingHoursSpecification` array of objects with `@type: OpeningHoursSpecification`, `dayOfWeek` (full English names), `opens`/`closes` in `HH:MM` format.
**Warning signs:** Google Rich Results Test shows warnings about hours.

### Pitfall 2: Hreflang Without x-default
**What goes wrong:** Search engines can't determine the default language version.
**Why it happens:** Only adding hreflang for it/en but forgetting `x-default`.
**How to avoid:** Always include `<link rel="alternate" hreflang="x-default" href="...">` pointing to the default language (Italian).

### Pitfall 3: Srcset Without Proper sizes Attribute
**What goes wrong:** Browser downloads largest image regardless of viewport.
**Why it happens:** `srcset` with width descriptors requires `sizes` attribute to work correctly.
**How to avoid:** Always pair srcset with a `sizes` attribute matching the CSS layout (e.g., `(min-width: 1024px) 33vw, 100vw`).

### Pitfall 4: WebP Without Fallback
**What goes wrong:** Older browsers (rare but possible) can't display images.
**Why it happens:** Using WebP in `<img>` src directly.
**How to avoid:** Use `<picture>` element with WebP in `<source>` and original format in `<img>` fallback.

### Pitfall 5: Kirby Thumb Driver Missing GD/Imagick
**What goes wrong:** WebP conversion fails silently or returns original format.
**Why it happens:** PHP's GD extension doesn't support WebP on some servers, or Imagick not installed.
**How to avoid:** Verify `gd_info()['WebP Support']` or Imagick WebP support on production server. Kirby uses GD by default.

### Pitfall 6: JSON-LD Address Parsing from Textarea
**What goes wrong:** The site.yml `address` field is a textarea (multi-line text). Parsing street/city/postal from freeform text is fragile.
**How to avoid:** Either add structured address fields to site.yml (street, city, postalCode, etc.) OR hardcode address components in the page model since it's a single-location business that won't change often.

## Code Examples

### Complete JSON-LD Restaurant Schema

```json
{
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "Porta Vecia",
  "description": "Enoteca con cucina cinese autentica fatta in casa nel centro storico di Este",
  "url": "https://portavecia.it",
  "telephone": "+39...",
  "servesCuisine": ["Italian Wine", "Chinese Cuisine"],
  "priceRange": "$$",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Via ...",
    "addressLocality": "Este",
    "addressRegion": "PD",
    "postalCode": "35042",
    "addressCountry": "IT"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "45.2269",
    "longitude": "11.6569"
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Tuesday", "Wednesday", "Thursday"],
      "opens": "17:00",
      "closes": "23:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Friday", "Saturday"],
      "opens": "17:00",
      "closes": "00:00"
    }
  ],
  "menu": "https://portavecia.it/it/menu",
  "image": "https://portavecia.it/media/..."
}
```

### Kirby Config for Meta + Sitemap + Thumbs

```php
<?php
return [
    'debug' => true,
    'languages' => true,
    'languages.detect' => false,

    // Vite integration
    'johannschopplich.helpers.vite' => [
        'entry' => 'src/js/main.js',
        'outDir' => 'dist',
    ],

    // Enable sitemap and robots
    'johannschopplich.helpers.sitemap.enabled' => true,
    'johannschopplich.helpers.robots.enabled' => true,

    // Meta defaults (fallback when page fields empty)
    'johannschopplich.helpers.meta.defaults' => function ($kirby, $site, $page) {
        return [
            'description' => $site->description()->value(),
            'opengraph' => [
                'locale' => $kirby->language()->code() === 'it' ? 'it_IT' : 'en_US',
            ],
        ];
    },

    // Thumb srcset presets
    'thumbs' => [
        'srcsets' => [
            'default' => [
                '320w'  => ['width' => 320, 'quality' => 80],
                '640w'  => ['width' => 640, 'quality' => 80],
                '960w'  => ['width' => 960, 'quality' => 80],
                '1280w' => ['width' => 1280, 'quality' => 80],
                '1920w' => ['width' => 1920, 'quality' => 80],
            ],
            'default-webp' => [
                '320w'  => ['width' => 320, 'format' => 'webp', 'quality' => 80],
                '640w'  => ['width' => 640, 'format' => 'webp', 'quality' => 80],
                '960w'  => ['width' => 960, 'format' => 'webp', 'quality' => 80],
                '1280w' => ['width' => 1280, 'format' => 'webp', 'quality' => 80],
                '1920w' => ['width' => 1920, 'format' => 'webp', 'quality' => 80],
            ],
        ],
    ],
];
```

### Files to Modify (Inventory)

| File | Change | Requirement |
|------|--------|-------------|
| `site/config/config.php` | Add sitemap/robots/meta/thumbs config | SEO-01, SEO-03, SEO-04 |
| `site/blueprints/site.yml` | Add SEO tab with description, thumbnail as global fallbacks; add structured address fields | SEO-01, SEO-02 |
| `site/blueprints/pages/home.yml` | Add SEO tab | SEO-01 |
| `site/blueprints/pages/about.yml` | Add SEO tab | SEO-01 |
| `site/blueprints/pages/menu.yml` | Add SEO tab | SEO-01 |
| `site/blueprints/pages/wines.yml` | Add SEO tab | SEO-01 |
| `site/blueprints/pages/gallery.yml` | Add SEO tab | SEO-01 |
| `site/blueprints/pages/events.yml` | Add SEO tab | SEO-01 |
| `site/blueprints/pages/contact.yml` | Add SEO tab | SEO-01 |
| `site/snippets/layout/header.php` | Replace title, add meta/hreflang/jsonld output | SEO-01, SEO-02, SEO-03 |
| `site/models/home.php` | Create -- metadata() with Restaurant JSON-LD | SEO-02 |
| `site/models/contact.php` | Create -- metadata() with Restaurant JSON-LD | SEO-02 |
| `site/snippets/components/responsive-image.php` | Create -- reusable picture/srcset/webp snippet | SEO-04 |
| `site/snippets/sections/hero-video.php` | Update poster image to use srcset (no lazy) | SEO-04 |
| `site/snippets/sections/section-teaser.php` | Replace thumb() with responsive-image snippet | SEO-04 |
| `site/snippets/sections/section-preview.php` | Replace thumb() with responsive-image snippet | SEO-04 |
| `site/snippets/sections/section-story.php` | Replace thumb() with responsive-image snippet | SEO-04 |
| `site/snippets/sections/about-block.php` | Replace thumb() with responsive-image snippet | SEO-04 |
| `site/snippets/sections/dish-card.php` | Replace thumb() with responsive-image snippet | SEO-04 |
| `site/snippets/sections/wine-row.php` | Replace thumb() with responsive-image snippet | SEO-04 |
| `site/snippets/sections/event-card.php` | Replace thumb() with responsive-image snippet | SEO-04 |
| `site/templates/gallery.php` | Replace thumb() with responsive-image/gallery preset | SEO-04 |

## Open Questions

1. **Exact address components**
   - What we know: site.yml has an `address` textarea field with freeform text
   - What's unclear: Exact street, postal code for JSON-LD structured address
   - Recommendation: Add structured address fields to site.yml (street_address, city, postal_code, latitude, longitude) OR hardcode in page model since single-location business

2. **Opening hours mapping**
   - What we know: site.yml has `hours` structure field with `day`/`time` text fields
   - What's unclear: The day/time format may not map cleanly to Schema.org `dayOfWeek` (English full names) and `opens`/`closes` (HH:MM)
   - Recommendation: Parse existing hours structure or hardcode in JSON-LD since hours change rarely. If parsing, the day field text needs mapping (e.g., "Lunedi" -> "Monday")

3. **GD WebP support on target host**
   - What we know: Hosting not yet decided
   - What's unclear: Whether production PHP has GD with WebP support
   - Recommendation: The `<picture>` fallback pattern handles this gracefully. If WebP generation fails, the original format `<img>` still works.

## Sources

### Primary (HIGH confidence)
- [Kirby Responsive Images Cookbook](https://getkirby.com/docs/cookbook/performance/responsive-images) - srcset config presets, picture element pattern, WebP format usage
- [Kirby $file->srcset() API](https://getkirby.com/docs/reference/objects/cms/file/srcset) - Method signature, parameters, preset usage
- [johannschopplich/kirby-helpers source code](site/plugins/kirby-helpers/) - PageMeta, SiteMeta classes verified locally: cascade behavior, jsonld(), social(), robots(), sitemap generation with multilingual hreflang
- [Google LocalBusiness Structured Data](https://developers.google.com/search/docs/appearance/structured-data/local-business) - Required/recommended properties, openingHoursSpecification format, address format
- [Schema.org Restaurant](https://schema.org/Restaurant) - Restaurant type properties including servesCuisine

### Secondary (MEDIUM confidence)
- [johannschopplich/kirby-helpers meta docs](https://github.com/johannschopplich/kirby-helpers/blob/main/docs/meta.md) - Blueprint field expectations (customtitle, description, thumbnail), metadata() method pattern, config defaults

## Metadata

**Confidence breakdown:**
- Standard stack: HIGH - kirby-helpers plugin already installed and source code verified locally
- Architecture: HIGH - Kirby srcset/thumbs API verified via official docs; kirby-helpers meta/sitemap verified via source code
- Pitfalls: HIGH - Based on official docs, Google structured data requirements, and codebase inspection

**Research date:** 2026-04-09
**Valid until:** 2026-05-09 (stable -- Kirby 5 and kirby-helpers APIs unlikely to change)
