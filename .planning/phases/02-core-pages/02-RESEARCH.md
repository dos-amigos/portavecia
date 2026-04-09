# Phase 2: Core Pages - Research

**Researched:** 2026-04-09
**Domain:** Kirby CMS page templates, blueprints, bilingual content, Leaflet maps, video hero, restaurant UI patterns
**Confidence:** HIGH

## Summary

Phase 2 builds 5 content pages (Homepage, Chi Siamo, Menu/Cucina, Vini, Contatti) on top of Phase 1's global layout. The codebase already has a working header/footer, Alpine.js, Tailwind CSS 4 theme tokens, language files, and a site controller providing global data. Each page needs: a Kirby blueprint (for Panel editing), a template (for rendering), optional snippets (for reusable sections), and bilingual content files.

The main technical decisions are straightforward: Kirby structure fields for repeatable items (dishes, wines), Leaflet.js with openstreetmap.de tiles for GDPR-safe maps, HTML5 `<video>` for hero background, and a WhatsApp floating button using pure CSS/Alpine.js. All content must be editable from Kirby Panel and available in both IT/EN.

**Primary recommendation:** Use Kirby's official restaurant menu pattern (structure fields with reusable field definitions) for dishes and wines. Use Leaflet via CDN (not npm) to avoid bundling a large library. Keep the floating WhatsApp button as a global snippet included in the layout.

<user_constraints>
## User Constraints (from CONTEXT.md)

### Locked Decisions
- D-01: Hero uses video background -- `preparazione-spaghetti-di-riso.mp4` from `_sources/` plus free stock video from Pexels. Autoplay muted loop with text overlay and WhatsApp CTA.
- D-02: Homepage section order below hero -- Claude decides optimal arrangement.
- D-03: WhatsApp CTA in hero AND floating button (bottom-right, chat-widget style) on ALL pages site-wide.
- D-04: Free stock videos from Pexels/Pixabay throughout homepage sections.
- D-05: Menu dishes as cards with photos, organized by category. Use real `_sources/` photos.
- D-06: Wine pairing on main dishes -- Claude decides presentation format.
- D-07: Wine page as vertical elegant list -- bottle photo left, details right. One wine per row.
- D-08: Map uses OpenStreetMap (Leaflet) embedded directly. Separate "Indicazioni" button opens Google Maps in new tab. No Google Maps iframe.
- D-09: Contact page split layout -- map left, contact info right. Stacks vertically on mobile.
- D-10: Chi Siamo uses alternating storytelling blocks (text/image alternate sides).
- D-11: All page content uses realistic placeholder text by Claude in both IT and EN.
- D-12: All content editable from Kirby Panel with structured blueprint fields.

### Claude's Discretion
- Homepage section ordering (D-02) -- optimize for engagement
- Wine pairing format on menu cards (D-06)
- Specific video stock selections
- Animation/transition choices (keep elegant and subtle)
- Responsive breakpoints and mobile adaptations

### Deferred Ideas (OUT OF SCOPE)
- Video atmosferico professionale per hero (ADV-01)
- Sezione "Piatto del momento" in homepage (ADV-02)
- Google Reviews curate (ADV-03)
</user_constraints>

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|----|-------------|------------------|
| HOME-01 | Hero section with strong imagery and WhatsApp CTA | Video background pattern (autoplay/muted/loop/playsinline), WhatsApp `wa.me` link format |
| HOME-02 | Fusion concept teaser section | Candore-style alternating text/image sections, Kirby blueprint fields |
| HOME-03 | Featured wines/dishes previews linking to pages | Structure fields or manual blueprint fields, `$site->find('wines')` linking pattern |
| HOME-04 | "L'Esperienza" storytelling section | Kirby textarea/image fields, Tailwind prose styling |
| ABOUT-01 | Story, philosophy, interior/plateatico photos | Alternating block pattern (D-10), files field for images |
| ABOUT-02 | "Due Tradizioni, Un Tavolo" fusion concept | Kirby blueprint section with text + image fields |
| MENU-01 | HTML menu with categories, name, description, price | Kirby structure field (official restaurant menu pattern) |
| MENU-02 | Wine pairing suggestions on main dishes | Text field within structure entry for pairing note |
| MENU-03 | Editable from Kirby Panel | Blueprint with structure fields, tabs for categories |
| WINE-01 | Wine showcase with photo, name, origin, notes, price | Structure field with files field for bottle photo |
| WINE-02 | Food pairing suggestions per wine | Text field within wine structure entry |
| WINE-03 | Editable from Kirby Panel | Blueprint with wine structure field |
| CONT-01 | Embedded map | Leaflet.js 1.9.4 + openstreetmap.de tiles (GDPR-safe) |
| CONT-02 | Opening hours clearly visible | Reuse existing `$hours` from site controller |
| CONT-03 | WhatsApp and phone one-tap buttons | `tel:` and `wa.me` href patterns, existing `$phone`/`$whatsapp` data |
| CONT-04 | Full address with directions | Address from site controller + Google Maps directions link |
| LANG-01 | All content in Italian and English | Kirby `.it.txt`/`.en.txt` content files, `t()` for UI strings |
</phase_requirements>

## Standard Stack

### Core (already installed)
| Library | Version | Purpose | Why Standard |
|---------|---------|---------|--------------|
| Kirby CMS | 5.x | Content management, blueprints, Panel | Project foundation, already installed |
| Tailwind CSS | 4.2.x | Utility-first styling | Already configured with theme tokens |
| Alpine.js | 3.15.x | Interactive components | Already initialized, used for mobile menu |
| Vite | 8.x | Build tool | Already configured |

### New for Phase 2
| Library | Version | Purpose | When to Use |
|---------|---------|---------|-------------|
| Leaflet.js | 1.9.4 | Interactive map on contact page | Load via CDN in contact template only -- do NOT npm install |

### Not Needed
| Library | Why Not |
|---------|---------|
| GSAP/ScrollTrigger | Defer to later phase. Phase 2 focuses on content structure and Panel editability. Subtle CSS transitions suffice. |
| Swiper | No carousel needed in Phase 2 core pages. Can add later if needed. |
| GLightbox | Gallery is Phase 3. Not needed here. |

**Leaflet CDN (load only on contact page):**
```html
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
```

## Architecture Patterns

### Page File Structure
```
site/
├── blueprints/
│   ├── fields/           # Reusable field definitions
│   │   └── dishes.yml    # Shared dish structure (name, desc, price, photo, pairing)
│   └── pages/
│       ├── home.yml      # Homepage blueprint (hero, sections)
│       ├── about.yml     # Chi Siamo blueprint
│       ├── menu.yml      # Menu/Cucina blueprint (extends fields/dishes)
│       ├── wines.yml     # Vini blueprint
│       └── contact.yml   # Contatti blueprint
├── controllers/
│   ├── site.php          # Global data (already exists)
│   └── menu.php          # Menu categories helper (optional)
├── snippets/
│   ├── components/
│   │   ├── whatsapp-float.php  # Floating WhatsApp button (global)
│   │   └── language-switch.php # (already exists)
│   └── sections/
│       ├── hero-video.php      # Video hero with overlay
│       ├── section-teaser.php  # Fusion concept teaser
│       ├── section-preview.php # Featured items preview
│       ├── section-story.php   # L'Esperienza storytelling
│       ├── about-block.php     # Alternating text/image block
│       ├── dish-card.php       # Single dish card
│       ├── wine-row.php        # Single wine list row
│       └── contact-map.php     # Leaflet map snippet
├── templates/
│   ├── home.php          # Homepage template
│   ├── about.php         # Chi Siamo template
│   ├── menu.php          # Menu/Cucina template
│   ├── wines.php         # Vini template
│   └── contact.php       # Contatti template
└── languages/
    ├── it.php            # Add new translation keys
    └── en.php            # Add new translation keys

content/
├── 1_home/
│   ├── home.it.txt       # Italian content
│   └── home.en.txt       # English content
├── 2_about/
│   ├── about.it.txt
│   └── about.en.txt
├── 3_menu/
│   ├── menu.it.txt
│   └── menu.en.txt
├── 4_wines/
│   ├── wines.it.txt
│   └── wines.en.txt
└── 5_contact/
    ├── contact.it.txt
    └── contact.en.txt
```

### Pattern 1: Kirby Blueprint with Structure Fields (Menu/Wine)
**What:** Use Kirby's structure field for repeatable data entries (dishes, wines)
**When to use:** Any list of items with consistent fields that the owner edits from Panel
**Example:**
```yaml
# site/blueprints/fields/dishes.yml
# Source: https://getkirby.com/docs/reference/panel/samples/menu
label: Piatti
type: structure
sortable: true
fields:
  dish_name:
    label: Nome piatto
    type: text
    width: 1/4
    required: true
  description:
    label: Descrizione
    type: textarea
    width: 1/4
  price:
    label: Prezzo
    type: number
    before: "€"
    step: 0.5
    width: 1/6
  photo:
    label: Foto
    type: files
    query: page.images
    multiple: false
    width: 1/6
  wine_pairing:
    label: Abbinamento vino
    type: text
    width: 1/6
```

```yaml
# site/blueprints/pages/menu.yml
title: Menu
tabs:
  antipasti:
    label: Antipasti
    fields:
      antipasti:
        extends: fields/dishes
        label: Antipasti
  primi:
    label: Primi
    fields:
      primi:
        extends: fields/dishes
        label: Primi Piatti
  secondi:
    label: Secondi
    fields:
      secondi:
        extends: fields/dishes
        label: Secondi Piatti
  dolci:
    label: Dolci
    fields:
      dolci:
        extends: fields/dishes
        label: Dolci
```

### Pattern 2: Template with Structure Field Rendering
**What:** Iterate structure field data in templates
**When to use:** Rendering dishes, wines, hours, or any structured list
**Example:**
```php
<?php // Template pattern for rendering dishes from a structure field
$categories = ['antipasti', 'primi', 'secondi', 'dolci'];
foreach ($categories as $cat): ?>
  <?php $dishes = $page->$cat()->toStructure(); ?>
  <?php if ($dishes->count()): ?>
    <section class="section-padding">
      <div class="container-site">
        <h2 class="font-heading text-3xl text-primary mb-8"><?= t("menu.$cat") ?></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <?php foreach ($dishes as $dish): ?>
            <?php snippet('sections/dish-card', ['dish' => $dish]) ?>
          <?php endforeach ?>
        </div>
      </div>
    </section>
  <?php endif ?>
<?php endforeach ?>
```

### Pattern 3: Video Hero Background
**What:** Full-viewport video background with text overlay
**When to use:** Homepage hero section
**Example:**
```php
<section class="relative h-screen flex items-center justify-center overflow-hidden">
  <!-- Video background -->
  <video
    autoplay muted loop playsinline
    class="absolute inset-0 w-full h-full object-cover"
    poster="<?= $page->hero_poster()->toFile()?->url() ?>"
  >
    <source src="<?= $page->hero_video()->toFile()?->url() ?>" type="video/mp4">
  </video>
  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-dark/60"></div>
  <!-- Content -->
  <div class="relative z-10 text-center px-4 max-w-3xl">
    <h1 class="font-heading text-5xl md:text-7xl text-light mb-6"><?= $page->hero_title() ?></h1>
    <p class="text-light/80 text-lg md:text-xl mb-8"><?= $page->hero_subtitle() ?></p>
    <a href="https://wa.me/<?= str_replace(['+', ' '], '', $whatsapp) ?>"
       class="btn-primary" target="_blank" rel="noopener">
      <?= t('cta.whatsapp') ?>
    </a>
  </div>
</section>
```

### Pattern 4: Floating WhatsApp Button (Global)
**What:** Fixed-position WhatsApp button visible on all pages
**When to use:** Include in layout footer or header snippet
**Example:**
```php
<!-- site/snippets/components/whatsapp-float.php -->
<?php if ($whatsapp): ?>
<a href="https://wa.me/<?= str_replace(['+', ' '], '', $whatsapp) ?>?text=<?= urlencode(t('whatsapp.default_message')) ?>"
   class="fixed bottom-6 right-6 z-40 w-14 h-14 bg-[#25D366] rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform"
   target="_blank" rel="noopener"
   aria-label="WhatsApp">
  <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.468l4.572-1.458A11.927 11.927 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818c-2.168 0-4.21-.567-5.975-1.558l-.427-.244-2.715.866.832-2.64-.272-.443A9.774 9.774 0 012.182 12c0-5.42 4.398-9.818 9.818-9.818S21.818 6.58 21.818 12 17.42 21.818 12 21.818z"/>
  </svg>
</a>
<?php endif ?>
```

### Pattern 5: Leaflet Map (Contact Page)
**What:** GDPR-safe OpenStreetMap embed with marker
**When to use:** Contact page only
**Example:**
```php
<!-- Load Leaflet CSS/JS only on contact page -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<div id="map" class="h-80 md:h-full rounded-lg z-0"></div>
<script>
  // Use openstreetmap.de tiles (hosted in Germany) for GDPR compliance
  const map = L.map('map').setView([45.2272, 11.6574], 16);
  L.tileLayer('https://{s}.tile.openstreetmap.de/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);
  L.marker([45.2272, 11.6574]).addTo(map)
    .bindPopup('<strong>Porta Vecia</strong><br>Enoteca & Cucina Cinese')
    .openPopup();
</script>
```

### Anti-Patterns to Avoid
- **Google Maps iframe:** Violates D-08 and causes GDPR cookie consent complexity. Use Leaflet + OSM.
- **PDF menu:** Explicitly out of scope. Always render menu as HTML.
- **Hardcoded content in templates:** All visible text must come from Kirby content fields or `t()` translation keys.
- **npm-installing Leaflet:** Adds unnecessary bundle size. CDN load on single page is lighter.
- **Using openstreetmap.org tiles directly:** IP data goes to US/Canada servers. Use openstreetmap.de (Germany-hosted) for GDPR safety.
- **Separate controller per page when unnecessary:** The global `site.php` controller already provides `$phone`, `$whatsapp`, `$hours`, etc. Only add page-specific controllers if truly needed.

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Dish/wine data management | Custom YAML parsing | Kirby structure field + `toStructure()` | Built-in Panel UI, sorting, validation |
| Interactive map | Custom tile loading | Leaflet.js | Battle-tested, accessible, mobile-friendly |
| Image thumbnails/srcset | Manual resize logic | Kirby `$image->thumb()` and `$image->srcset()` | Built-in async thumb generation, format conversion |
| Bilingual routing | Manual URL parsing | Kirby multilingual system | Built-in language detection, URL prefixing, Panel UI |
| Reusable blueprint fields | Copy-paste field defs | `extends: fields/dishes` pattern | DRY, single source of truth |

## Common Pitfalls

### Pitfall 1: Video File Size Kills Mobile Performance
**What goes wrong:** Hero video loads 20+ MB on mobile, causing slow page load and high data usage.
**Why it happens:** Raw video from `_sources/` is not optimized for web.
**How to avoid:** Compress video to under 3-4 MB for 720p. Use `poster` attribute for immediate visual. Consider hiding video on mobile (`hidden md:block`) and showing poster image only. Target 24-30fps, 10-15 second loop.
**Warning signs:** Lighthouse performance score drops, video buffering visible on 4G.

### Pitfall 2: Structure Field Images Don't Auto-Upload
**What goes wrong:** Adding a `files` field inside a structure field requires the images to already be uploaded to the page.
**Why it happens:** Structure field `files` field uses `query: page.images` -- it references existing page files, not a file upload widget.
**How to avoid:** In blueprints, add a separate `files` section (type: files) on the same page so the owner can upload images first, then reference them in structure entries. Or use a dedicated files section tab.
**Warning signs:** Empty file picker in Panel structure entries.

### Pitfall 3: Missing Content Files Break Multilingual
**What goes wrong:** Pages show empty content or wrong language fallback.
**Why it happens:** Kirby requires `.it.txt` AND `.en.txt` files for each page. If English file is missing, content falls back to Italian without clear indication.
**How to avoid:** Always create both language content files. Include all fields in both files, even if initially identical. The blueprint must match content file field names exactly.
**Warning signs:** Language switch appears to do nothing, or shows Italian text on English pages.

### Pitfall 4: openstreetmap.org vs openstreetmap.de GDPR
**What goes wrong:** D-08 states "zero GDPR issues" but standard OSM tiles route through US/Canada CDN.
**Why it happens:** openstreetmap.org uses Fastly CDN (US), which transmits user IPs to non-EU servers.
**How to avoid:** Use `{s}.tile.openstreetmap.de` tile URL instead. Hosted in Germany (Hetzner), stays within EU.
**Warning signs:** Privacy audit flags external requests to non-EU servers.

### Pitfall 5: Leaflet CSS Missing Breaks Map Display
**What goes wrong:** Map container collapses to 0 height, tiles render incorrectly, markers offset.
**Why it happens:** Leaflet CSS not loaded before map initialization, or map container has no explicit height.
**How to avoid:** Always load Leaflet CSS in `<head>`, set explicit height on map container (`h-80` or similar), initialize map after DOM ready.
**Warning signs:** Invisible map area, grey tiles with gaps, mispositioned markers.

### Pitfall 6: Content Directory in Git
**What goes wrong:** Local content files conflict with production Panel edits.
**Why it happens:** `content/` not in `.gitignore` (but Phase 1 decision already set this).
**How to avoid:** Already decided in Phase 1 -- `content/` is gitignored. For Phase 2, create content files locally for dev but do NOT commit them. Document the expected content structure in the plan.
**Warning signs:** Git conflicts in `.txt` files.

## Code Examples

### Kirby Blueprint: Homepage with Tabs
```yaml
# site/blueprints/pages/home.yml
title: Home
tabs:
  hero:
    label: Hero
    fields:
      hero_title:
        label: Titolo Hero
        type: text
        required: true
      hero_subtitle:
        label: Sottotitolo Hero
        type: textarea
        size: small
      hero_video:
        label: Video Background
        type: files
        query: page.files.filterBy('extension', 'mp4')
        multiple: false
      hero_poster:
        label: Poster Image (fallback)
        type: files
        query: page.images
        multiple: false
  sections:
    label: Sezioni
    fields:
      teaser_title:
        label: Titolo Teaser
        type: text
      teaser_text:
        label: Testo Teaser
        type: textarea
      teaser_image:
        label: Immagine Teaser
        type: files
        query: page.images
        multiple: false
      # ... additional section fields
  previews:
    label: Anteprime
    fields:
      featured_dishes:
        label: Piatti in evidenza
        type: structure
        max: 3
        fields:
          name:
            label: Nome
            type: text
          image:
            label: Foto
            type: files
            query: page.images
            multiple: false
          link_text:
            label: Testo link
            type: text
      featured_wines:
        label: Vini in evidenza
        type: structure
        max: 3
        fields:
          name:
            label: Nome
            type: text
          image:
            label: Foto
            type: files
            query: page.images
            multiple: false
```

### Kirby Blueprint: Wine Page
```yaml
# site/blueprints/pages/wines.yml
title: Vini
tabs:
  content:
    label: Contenuto
    fields:
      headline:
        label: Titolo pagina
        type: text
      intro:
        label: Introduzione
        type: textarea
  wines:
    label: Selezione Vini
    sections:
      wines_images:
        label: Foto bottiglie
        type: files
        layout: cards
        image:
          ratio: 2/3
          cover: true
    fields:
      wines:
        label: Vini
        type: structure
        sortable: true
        fields:
          name:
            label: Nome
            type: text
            width: 1/3
            required: true
          origin:
            label: Origine
            type: text
            width: 1/3
          grape:
            label: Vitigno
            type: text
            width: 1/3
          tasting_notes:
            label: Note di degustazione
            type: textarea
            size: small
            width: 1/2
          food_pairing:
            label: Abbinamento cibo
            type: text
            width: 1/2
          price:
            label: Prezzo
            type: number
            before: "€"
            step: 0.5
            width: 1/4
          photo:
            label: Foto bottiglia
            type: files
            query: page.images
            multiple: false
            width: 3/4
```

### Responsive Alternating Blocks (Chi Siamo)
```php
<?php
// Pattern for alternating text/image blocks
$blocks = [
  ['field' => 'story', 'image' => 'story_image'],
  ['field' => 'place', 'image' => 'place_image'],
  ['field' => 'fusion', 'image' => 'fusion_image'],
  ['field' => 'atmosphere', 'image' => 'atmosphere_image'],
];
foreach ($blocks as $i => $block):
  $reverse = $i % 2 !== 0;
?>
<section class="section-padding">
  <div class="container-site grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
    <div class="<?= $reverse ? 'md:order-2' : '' ?>">
      <h2 class="font-heading text-3xl text-primary mb-6">
        <?= $page->{$block['field'] . '_title'}() ?>
      </h2>
      <div class="prose prose-invert">
        <?= $page->{$block['field'] . '_text'}()->kirbytext() ?>
      </div>
    </div>
    <div class="<?= $reverse ? 'md:order-1' : '' ?>">
      <?php if ($img = $page->{$block['image']}()->toFile()): ?>
        <img src="<?= $img->thumb(['width' => 800, 'quality' => 80])->url() ?>"
             alt="<?= $img->alt() ?>"
             class="rounded-lg w-full"
             loading="lazy">
      <?php endif ?>
    </div>
  </div>
</section>
<?php endforeach ?>
```

### Bilingual Content File Structure
```
# content/3_menu/menu.it.txt
Title: La Nostra Cucina
----
Headline: Cucina Cinese Fatta in Casa
----
Intro: Ogni piatto e preparato al momento con ingredienti freschi...
----
Antipasti:
-
  dish_name: Ravioli Cinesi al Vapore
  description: Delicati ravioli ripieni di carne e verdure...
  price: "8"
  wine_pairing: Prosecco DOC

# content/3_menu/menu.en.txt
Title: Our Kitchen
----
Headline: Homemade Chinese Cuisine
----
Intro: Every dish is prepared fresh with quality ingredients...
----
Antipasti:
-
  dish_name: Steamed Chinese Dumplings
  description: Delicate dumplings filled with meat and vegetables...
  price: "8"
  wine_pairing: Prosecco DOC
```

## State of the Art

| Old Approach | Current Approach | When Changed | Impact |
|--------------|------------------|--------------|--------|
| Google Maps iframe | Leaflet + OSM tiles | GDPR enforcement | No consent needed for EU-hosted tiles |
| `<video>` without playsinline | autoplay muted loop playsinline | iOS Safari requirement | Without playsinline, iOS forces fullscreen |
| Tailwind config JS file | CSS-first @theme directive | Tailwind CSS 4 (2025) | Already using this in Phase 1 |
| Manual srcset markup | Kirby `$image->srcset()` | Kirby 4+ | Built-in responsive image handling |
| openstreetmap.org tiles | openstreetmap.de tiles | GDPR awareness ~2023 | German-hosted, no non-EU data transfer |

## Open Questions

1. **Exact coordinates for Porta Vecia**
   - What we know: The venue is in the historic center of Este (PD). Este center is approximately 45.2272, 11.6574.
   - What's unclear: The exact street address and precise GPS coordinates.
   - Recommendation: Use approximate Este center coordinates as placeholder. The client or developer can update via Kirby Panel or config. Consider making coordinates configurable in site.yml blueprint.

2. **Video compression for hero**
   - What we know: `preparazione-spaghetti-di-riso.mp4` exists in `_sources/`. Web hero videos should be under 3-4 MB.
   - What's unclear: Current file size and quality of the source video.
   - Recommendation: Plan a task to compress/optimize the video (ffmpeg or online tool). Provide poster image fallback.

3. **Menu categories matching actual offerings**
   - What we know: Photos show ravioli, spaghetti di riso, wonton soup, fish plates, meatballs -- suggesting categories like Antipasti, Primi, Secondi, Zuppe.
   - What's unclear: Exact category names the owner uses.
   - Recommendation: Use placeholder categories (Antipasti, Primi Piatti, Secondi, Zuppe, Dolci). Owner edits via Panel.

4. **Stock video sources**
   - What we know: D-04 requests free stock videos from Pexels/Pixabay for homepage sections.
   - What's unclear: Which specific videos and where exactly they go.
   - Recommendation: Search for 2-3 short clips (wok cooking, wine pouring, elegant dining) during implementation. Keep them under 2 MB each.

## Project Constraints (from CLAUDE.md)

- **Commit frequently:** Every modification, even small, must be committed immediately with descriptive message.
- **Never take initiative:** Do not make unrequested modifications. Ask confirmation for complex/risky changes.
- **Search online:** For any technical doubt, verify against official documentation online.
- **Tech stack:** Kirby CMS (PHP), bilingual IT/EN, no database.
- **Reservations:** WhatsApp/phone only, no booking forms.
- **Brand:** Logo from client, visual identity inspired by Candore.
- **GSD Workflow:** Use GSD entry points for all file changes.

## Sources

### Primary (HIGH confidence)
- [Kirby Restaurant Menu Sample](https://getkirby.com/docs/reference/panel/samples/menu) - Official blueprint pattern for dishes
- [Kirby Structure Field](https://getkirby.com/docs/reference/panel/fields/structure) - Field configuration, toStructure() usage
- [Kirby Files Field](https://getkirby.com/docs/reference/panel/fields/files) - Image handling in blueprints
- [Kirby Blueprint Layout](https://getkirby.com/docs/guide/blueprints/layout) - Tabs, sections, columns

### Secondary (MEDIUM confidence)
- [Leaflet Quick Start](https://leafletjs.com/examples/quick-start/) - Map initialization pattern
- [Leaflet npm](https://www.npmjs.com/package/leaflet) - Version 1.9.4 confirmed
- [OpenStreetMap GDPR Discussion](https://community.openstreetmap.org/t/osm-dsgvo-konform-und-ohne-einwilligung-nutzen/96228) - openstreetmap.de as GDPR-safe alternative
- [HTML Video Best Practices 2026](https://thelinuxcode.com/html-video-loop-attribute-practical-patterns-for-2026-frontends/) - autoplay/muted/loop/playsinline requirements

### Tertiary (LOW confidence)
- [WhatsApp Floating Button Patterns](https://www.wattsahead.co/resources/floating-whatsapp-button-free) - CSS/HTML implementation patterns
- [Candore Template Demo](https://duruthemes.com/demo/html/candore/demo1/) - Visual design reference (not source code)

## Metadata

**Confidence breakdown:**
- Standard stack: HIGH - All libraries already installed except Leaflet (CDN, well-documented)
- Architecture: HIGH - Kirby patterns well-documented, Phase 1 established conventions
- Pitfalls: HIGH - Known issues verified against official docs and community forums

**Research date:** 2026-04-09
**Valid until:** 2026-05-09 (stable stack, no fast-moving dependencies)
