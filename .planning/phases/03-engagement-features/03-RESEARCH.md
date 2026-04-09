# Phase 3: Engagement Features - Research

**Researched:** 2026-04-09
**Domain:** Gallery (masonry + lightbox + filters) and Events page (Kirby CMS, Alpine.js, GLightbox)
**Confidence:** HIGH

## Summary

Phase 3 builds two new page templates -- Gallery and Events -- on top of established Kirby CMS patterns from Phases 1-2. The Gallery requires a masonry photo grid with category filtering (Alpine.js) and lightbox viewing (GLightbox via CDN). The Events page requires structured event cards with future/past separation, date-based sorting, and WhatsApp booking CTAs.

The codebase already has all foundational patterns: page template structure (`snippet('layout/header')` + `snippet('layout/footer')`), CDN library loading (Leaflet pattern in contact-map.php), card components (dish-card.php), bilingual translation keys (t() system), Tailwind component classes (.btn-primary, .section-padding, .container-site), and Alpine.js for interactivity. This phase is primarily about assembling these proven patterns into two new pages.

**Primary recommendation:** Use CSS `columns` for masonry (no JS library needed), GLightbox 3.3.1 via cdnjs CDN following the Leaflet loading pattern, Alpine.js `x-data` for filter state with dynamic GLightbox element rebuilding on filter change, and Kirby structure fields for events with `toDate()` filtering for future/past separation.

<user_constraints>
## User Constraints (from CONTEXT.md)

### Locked Decisions
- D-01: Masonry layout (Pinterest-style) -- CSS columns or lightweight JS, no heavy library
- D-02: Category filters as horizontal tab buttons with fade + reposition animation (Alpine.js)
- D-03: All 17 photos from `_sources/` used with pre-assigned categories (Locale, Piatti, Cucina)
- D-04: GLightbox with swipe, arrows, photo counter, captions
- D-05: Lightbox respects current filter -- only cycles through filtered photos
- D-06: Event cards with image -- consistent with dish-card.php style
- D-07: Separate future/past events with dimmed past styling
- D-08: 3-4 placeholder events (Degustazione Amarone, Serata Dim Sum, Aperitivo d'Estate, Wine & Wonton Night)
- D-09: Each event: title, date, time, description, image, optional WhatsApp prenota link
- D-10: All gallery captions and event content bilingual IT/EN
- D-11: Gallery photos manageable from Panel (upload, reorder, category, caption)
- D-12: Events manageable from Panel

### Claude's Discretion
- Masonry implementation approach (CSS columns vs JS)
- GLightbox configuration details
- Event card layout specifics (image ratio, spacing)
- Animation timing and easing for filter transitions
- How to handle "Vini" gallery category
- Responsive breakpoints for gallery grid columns

### Deferred Ideas (OUT OF SCOPE)
- Video gallery integration (ADV-01)
- Google Reviews integration (ADV-03)
- Event booking system beyond WhatsApp
</user_constraints>

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|----|-------------|------------------|
| GALL-01 | Galleria fotografica con lightbox | GLightbox 3.3.1 via CDN, CSS columns masonry, established CDN loading pattern from contact-map.php |
| GALL-02 | Foto organizzabili per categoria | Kirby file blueprint with select field for category, Alpine.js x-data filter state |
| GALL-03 | Gestibile da Kirby Panel | Files section with `template: gallery-image` blueprint, cards layout, category metadata per file |
| EVNT-01 | Pagina eventi con lista serate speciali | Structure field in events blueprint, `toDate()` + `time()` for future/past filtering |
| EVNT-02 | Ogni evento con data, descrizione, immagine | Structure field with date, textarea, files fields -- follows wines.yml pattern |
| EVNT-03 | Gestibile da Kirby Panel | Structure field with sortable: true, all fields editable in Panel |
</phase_requirements>

## Project Constraints (from CLAUDE.md)

- **Commit frequently** with descriptive messages for every change
- **Never take initiative** on unrequested modifications -- ask confirmation for complex/risky changes
- **Search online** for any technical doubts, do not rely on AI memory
- **Tech stack**: Kirby CMS (PHP), Vite 8, Tailwind CSS 4, Alpine.js
- **Bilingual**: IT/EN via Kirby multilingual system
- **No external booking**: WhatsApp/phone only

## Standard Stack

### Core (already installed)
| Library | Version | Purpose | Why Standard |
|---------|---------|---------|--------------|
| Kirby CMS | 5.x | Content management, Panel admin, file handling | Already installed, provides files section + structure fields + blueprints |
| Alpine.js | 3.15.x | Gallery filter interactivity | Already loaded globally, used for mobile menu and cookie consent |
| Tailwind CSS | 4.2.x | Styling via utility classes | Already configured with project theme tokens |

### New for this phase
| Library | Version | Purpose | When to Use |
|---------|---------|---------|-------------|
| GLightbox | 3.3.1 | Lightbox for gallery photos | CDN load on gallery template only |

**GLightbox CDN URLs (cdnjs, version-pinned):**
```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.1/css/glightbox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.1/js/glightbox.min.js"></script>
```

**No npm install needed** -- GLightbox loaded via CDN only on gallery page, following the same pattern as Leaflet on the contact page.

## Architecture Patterns

### New Files to Create
```
site/
  blueprints/
    files/
      gallery-image.yml      # File blueprint: category select + caption
    pages/
      gallery.yml             # Gallery page blueprint: files section
      events.yml              # Events page blueprint: structure field
  templates/
    gallery.php               # Gallery page template
    events.php                # Events page template
  snippets/
    sections/
      event-card.php          # Event card component (reuses dish-card pattern)
  controllers/
    events.php                # Events controller: future/past filtering
content/
  6_gallery/
    gallery.it.txt            # Gallery page content (IT)
    gallery.en.txt            # Gallery page content (EN)
    [photos copied from _sources/]
  7_events/
    events.it.txt             # Events page content (IT)
    events.en.txt             # Events page content (EN)
```

### Pattern 1: CSS Columns Masonry (Recommended)
**What:** Pure CSS masonry using `columns` property -- no JavaScript needed for layout.
**When to use:** Photo grids where items have different heights and you want a Pinterest-style layout.
**Why CSS columns over JS:** Zero JS overhead, works with Alpine.js x-show for filtering, browser handles reflow automatically when items are hidden/shown. CSS columns are well-supported (all modern browsers). No masonry library dependency.

```php
<!-- Gallery grid with CSS columns masonry -->
<div class="columns-2 md:columns-3 lg:columns-4 gap-3"
     x-data="galleryFilter()">

  <?php foreach ($page->images()->sortBy('sort') as $image): ?>
    <?php $category = $image->category()->value() ?: 'locale'; ?>
    <div class="break-inside-avoid mb-3"
         x-show="activeFilter === 'all' || '<?= $category ?>' === activeFilter"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
      <a href="<?= $image->url() ?>"
         class="glightbox block rounded-lg overflow-hidden group relative cursor-pointer"
         data-gallery="gallery"
         data-title="<?= $image->caption() ?>">
        <img src="<?= $image->thumb(['width' => 600, 'quality' => 80])->url() ?>"
             alt="<?= $image->alt()->or($image->caption()) ?>"
             class="w-full transition-transform duration-300 group-hover:scale-105"
             loading="lazy">
        <!-- Hover overlay with caption -->
        <div class="absolute inset-0 bg-dark/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
          <span class="text-light text-sm"><?= $image->caption() ?></span>
        </div>
      </a>
    </div>
  <?php endforeach ?>
</div>
```

### Pattern 2: Filter-Aware GLightbox Rebuild
**What:** Rebuild GLightbox elements array when filter changes so lightbox only cycles through visible photos.
**When to use:** D-05 requires lightbox to respect active filter.

```javascript
// In Alpine.js component or inline script
function galleryFilter() {
  return {
    activeFilter: 'all',
    lightbox: null,

    init() {
      this.buildLightbox();
    },

    setFilter(filter) {
      this.activeFilter = filter;
      // Wait for Alpine transitions to complete, then rebuild lightbox
      this.$nextTick(() => {
        setTimeout(() => this.buildLightbox(), 250);
      });
    },

    buildLightbox() {
      if (this.lightbox) {
        this.lightbox.destroy();
      }
      this.lightbox = GLightbox({
        selector: '.glightbox[style*="display: none"] ~ .placeholder-never-match, .glightbox:not([style*="display: none"])',
        // Better approach: use elements array
      });
    }
  }
}

// Alternative (cleaner): build elements array from visible DOM nodes
buildLightbox() {
  if (this.lightbox) this.lightbox.destroy();

  const visibleItems = this.$el.querySelectorAll('.glightbox');
  const elements = [];
  visibleItems.forEach(el => {
    if (el.offsetParent !== null) { // visible check
      elements.push({
        href: el.getAttribute('href'),
        type: 'image',
        title: el.getAttribute('data-title') || '',
      });
    }
  });

  this.lightbox = GLightbox({ elements, loop: true });

  // Attach click handlers to visible items
  visibleItems.forEach((el, i) => {
    if (el.offsetParent !== null) {
      el.addEventListener('click', (e) => {
        e.preventDefault();
        this.lightbox.openAt(i);
      });
    }
  });
}
```

**Important note on x-show and GLightbox:** Alpine.js `x-show` uses `display: none` to hide elements. GLightbox's selector-based initialization will include hidden elements. The solution is to use the `elements` array API and manually build it from visible DOM nodes, or destroy and recreate the lightbox instance on each filter change.

### Pattern 3: Kirby File Blueprint for Gallery Photos
**What:** Each uploaded gallery photo has metadata fields (category, caption) editable in Panel.
**When to use:** D-11 requires gallery photos manageable from Panel.

```yaml
# site/blueprints/files/gallery-image.yml
title: Foto Galleria
accept:
  mime: image/jpeg, image/png, image/webp
fields:
  caption:
    label: Didascalia
    type: text
    translate: true
  alt:
    label: Testo alternativo
    type: text
    translate: true
  category:
    label: Categoria
    type: select
    required: true
    default: locale
    options:
      locale: Locale
      piatti: Piatti
      vini: Vini
      cucina: Cucina
      eventi: Eventi
```

### Pattern 4: Events Structure Field with Future/Past Split
**What:** Structure field in events blueprint + controller with date filtering.
**When to use:** D-07 requires separate future and past events.

```php
// site/controllers/events.php
<?php
return function ($page) {
    $now = time();
    $events = $page->events()->toStructure();

    $upcoming = $events->filter(function ($event) use ($now) {
        return $event->event_date()->toDate() >= $now;
    })->sortBy('event_date', 'asc');

    $past = $events->filter(function ($event) use ($now) {
        return $event->event_date()->toDate() < $now;
    })->sortBy('event_date', 'desc');

    return compact('upcoming', 'past');
};
```

### Anti-Patterns to Avoid
- **Do NOT use JS masonry libraries** (Masonry.js, Isotope): CSS columns achieves the same result with zero JS for this use case. The filtering is handled by Alpine.js x-show, not by a layout engine.
- **Do NOT install GLightbox via npm**: Follow the established CDN pattern (Leaflet). Keeps the Vite bundle clean and loads only on the gallery page.
- **Do NOT use Kirby children pages for gallery images**: Use the files section with file blueprints. Each image as a child page is over-engineering for a simple photo gallery. Files section + file template gives Panel editing of metadata (category, caption) without the overhead.
- **Do NOT hardcode photo categories in PHP**: Use the file blueprint `category` select field so categories are editable from Panel.
- **Do NOT use inline style for Tailwind values**: Existing convention note says `bg-[#hex]` and similar arbitrary values do not compile. Use theme tokens or inline styles where needed.

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Photo lightbox | Custom modal with JS | GLightbox 3.3.1 (CDN) | Touch navigation, keyboard nav, photo counter, accessibility -- all built-in |
| Masonry grid layout | JS layout calculation | CSS `columns` property | Zero JS, browser-native reflow, works with Alpine.js show/hide |
| Date comparison for events | Custom date parsing | Kirby `toDate()` + PHP `time()` | Built-in Kirby field method, handles timezone and format parsing |
| Image thumbnails/optimization | Manual resize pipeline | Kirby `thumb()` with width/quality params | Built-in async thumbnail generation with caching |

## Common Pitfalls

### Pitfall 1: GLightbox Includes Hidden (Filtered) Photos
**What goes wrong:** GLightbox initialized with selector `.glightbox` will include all matching elements, even those hidden by Alpine.js `x-show` (display: none).
**Why it happens:** GLightbox scans the DOM on init and captures all matching elements regardless of visibility.
**How to avoid:** Use the `elements` array API instead of selector. Build the array from visible DOM nodes only. Destroy and recreate the GLightbox instance on each filter change.
**Warning signs:** Lightbox cycles through photos that should not be visible in the current filter.

### Pitfall 2: CSS Columns Order is Top-to-Bottom, Not Left-to-Right
**What goes wrong:** CSS columns fill top-to-bottom within each column, not left-to-right across columns. Photos appear in unexpected order.
**Why it happens:** CSS multi-column layout is designed for text flow (newspaper columns).
**How to avoid:** This is generally acceptable for a gallery (users don't expect strict left-to-right order). If strict order matters, consider CSS Grid with `grid-template-rows: masonry` (experimental) or accept the column-first order. For this project, column order is fine -- it creates a natural, organic gallery feel.
**Warning signs:** Photos that were uploaded sequentially appear scattered across columns.

### Pitfall 3: Bilingual Content Files Missing
**What goes wrong:** Creating only `.it.txt` content files and forgetting `.en.txt`, causing the English version to fall back to Italian or show blank content.
**Why it happens:** Kirby requires separate content files per language.
**How to avoid:** Always create both `gallery.it.txt` and `gallery.en.txt` (and same for events). Blueprint fields with `translate: true` ensure Panel shows translation tabs.
**Warning signs:** Switching to English shows Italian content or empty fields.

### Pitfall 4: Structure Field Date Format Mismatch
**What goes wrong:** Event dates entered in Panel don't sort correctly or `toDate()` returns unexpected values.
**Why it happens:** Kirby's date field must be configured with the correct format.
**How to avoid:** Use `type: date` in the blueprint (not `type: text`). Kirby stores dates as `YYYY-MM-DD` internally. Use `type: time` for the time field separately.
**Warning signs:** Events appear in wrong order or future/past split is incorrect.

### Pitfall 5: Large Images Without Thumbnails in Gallery Grid
**What goes wrong:** Full-resolution photos loaded in the grid, causing slow page loads.
**Why it happens:** Using `$image->url()` directly instead of `$image->thumb()`.
**How to avoid:** Use `$image->thumb(['width' => 600, 'quality' => 80])` for grid thumbnails. Use full resolution URL only for GLightbox `href` (lightbox view).
**Warning signs:** Gallery page loads slowly, especially on mobile.

### Pitfall 6: WhatsApp Event Booking URL Encoding
**What goes wrong:** Pre-filled WhatsApp message with event name/date breaks if not URL-encoded.
**Why it happens:** Event titles with special characters (accents, quotes) break the URL.
**How to avoid:** Use `rawurlencode()` for the message text in the `wa.me` URL.
**Warning signs:** WhatsApp opens but message is truncated or garbled.

## Code Examples

### Gallery Page Blueprint
```yaml
# site/blueprints/pages/gallery.yml
title: Galleria
tabs:
  content:
    label: Contenuto
    fields:
      headline:
        label: Titolo pagina
        type: text
        required: true
      intro:
        label: Sottotitolo
        type: textarea
        size: small
  photos:
    label: Foto
    sections:
      gallery_images:
        label: Foto Galleria
        type: files
        layout: cards
        template: gallery-image
        sortable: true
        image:
          cover: true
          ratio: 3/2
        info: "{{ file.category }}"
```

### Events Page Blueprint
```yaml
# site/blueprints/pages/events.yml
title: Eventi
tabs:
  content:
    label: Contenuto
    fields:
      headline:
        label: Titolo pagina
        type: text
        required: true
      intro:
        label: Sottotitolo
        type: textarea
        size: small
  events:
    label: Eventi
    fields:
      events:
        label: Lista Eventi
        type: structure
        sortable: true
        fields:
          title:
            label: Titolo
            type: text
            width: 1/2
            required: true
          event_date:
            label: Data
            type: date
            width: 1/4
            required: true
          event_time:
            label: Ora
            type: time
            width: 1/4
          description:
            label: Descrizione
            type: textarea
            size: small
          photo:
            label: Foto
            type: files
            query: page.images
            multiple: false
            width: 1/2
          whatsapp_booking:
            label: Prenotazione WhatsApp
            type: toggle
            default: true
            width: 1/2
            text:
              - "No"
              - "Si"
```

### Event Card Snippet (adapted from dish-card.php)
```php
<!-- site/snippets/sections/event-card.php -->
<div class="bg-dark/50 border border-light/10 rounded-lg overflow-hidden flex flex-col md:flex-row <?= $isPast ? 'opacity-60' : '' ?>">
  <?php if ($photo = $event->photo()->toFile()): ?>
    <div class="md:w-1/3 h-48 md:h-auto">
      <img src="<?= $photo->thumb(['width' => 400, 'height' => 300, 'crop' => true, 'quality' => 80])->url() ?>"
           alt="<?= $event->title() ?>"
           class="w-full h-full object-cover"
           loading="lazy">
    </div>
  <?php endif ?>
  <div class="p-6 flex-1 flex flex-col justify-between">
    <div>
      <p class="text-primary font-bold text-sm uppercase tracking-wider mb-2">
        <?= $event->event_date()->toDate('d F Y') ?>
        <?php if ($event->event_time()->isNotEmpty()): ?>
          - ore <?= $event->event_time() ?>
        <?php endif ?>
      </p>
      <h3 class="font-heading text-xl text-light mb-3"><?= $event->title() ?></h3>
      <?php if ($event->description()->isNotEmpty()): ?>
        <p class="text-light/70 text-sm"><?= $event->description() ?></p>
      <?php endif ?>
    </div>
    <?php if (!$isPast && $event->whatsapp_booking()->toBool() && $whatsapp): ?>
      <a href="https://wa.me/<?= str_replace(['+', ' '], '', $whatsapp) ?>?text=<?= rawurlencode(t('event.whatsapp_message', ['event' => $event->title(), 'date' => $event->event_date()->toDate('d/m/Y')])) ?>"
         class="btn-primary text-center mt-4"
         target="_blank" rel="noopener">
        <?= t('event.prenota') ?>
      </a>
    <?php endif ?>
  </div>
</div>
```

### Translation Keys to Add
```php
// Add to site/languages/it.php translations array:
'gallery.title' => 'Galleria',
'gallery.subtitle' => 'Scorci di atmosfera, piatti e momenti speciali',
'gallery.filter.all' => 'Tutto',
'gallery.filter.locale' => 'Locale',
'gallery.filter.piatti' => 'Piatti',
'gallery.filter.vini' => 'Vini',
'gallery.filter.cucina' => 'Cucina',
'gallery.filter.eventi' => 'Eventi',
'gallery.empty' => 'La galleria fotografica e in arrivo. Torna presto!',
'events.title' => 'Eventi',
'events.subtitle' => 'Serate speciali, degustazioni e momenti da condividere',
'events.upcoming' => 'Prossimi Eventi',
'events.past' => 'Eventi Passati',
'events.empty.title' => 'Nessun evento in programma',
'events.empty.body' => 'Seguici sui social per restare aggiornato sulle prossime serate speciali.',
'event.prenota' => 'Prenota su WhatsApp',
'event.whatsapp_message' => 'Ciao! Vorrei prenotare per l\'evento "{event}" del {date}.',

// Add to site/languages/en.php translations array:
'gallery.title' => 'Gallery',
'gallery.subtitle' => 'Glimpses of atmosphere, dishes, and special moments',
'gallery.filter.all' => 'All',
'gallery.filter.locale' => 'Venue',
'gallery.filter.piatti' => 'Dishes',
'gallery.filter.vini' => 'Wines',
'gallery.filter.cucina' => 'Kitchen',
'gallery.filter.eventi' => 'Events',
'gallery.empty' => 'Our photo gallery is coming soon. Check back later!',
'events.title' => 'Events',
'events.subtitle' => 'Special evenings, tastings, and moments to share',
'events.upcoming' => 'Upcoming Events',
'events.past' => 'Past Events',
'events.empty.title' => 'No upcoming events',
'events.empty.body' => 'Follow us on social media to stay updated on upcoming special evenings.',
'event.prenota' => 'Book on WhatsApp',
'event.whatsapp_message' => 'Hi! I\'d like to book for the event "{event}" on {date}.',
```

## Discretion Recommendations

### Masonry: Use CSS Columns (not JS)
CSS `columns-2 md:columns-3 lg:columns-4` is the correct choice. It produces a natural masonry layout with zero JavaScript. When Alpine.js hides items with `x-show`, the browser automatically reflows the columns. No masonry library is needed for this use case.

### GLightbox Configuration
- `loop: true` -- gallery wrapping feels natural
- `touchNavigation: true` -- already default, essential for mobile
- `closeOnOutsideClick: true` -- already default
- `zoomable: true` -- useful for food/venue photos
- Use the `elements` array API for filter-awareness, not the selector API

### Event Card Image Ratio
Use 3:2 aspect ratio (`thumb(['width' => 400, 'height' => 300, 'crop' => true])`) matching the dish-card pattern. On mobile, full-width image at `h-48`. On desktop, `md:w-1/3` with `object-cover`.

### Animation Timing
- Filter transitions: `duration-200` with `ease-out` (fast, responsive feel)
- Photo hover scale: `duration-300` (slightly slower for smoothness)
- These match the existing mobile menu transition timing in header.php

### "Vini" Gallery Category
Include it as a filter option even though there are currently no photos assigned to it. The client can add wine photos later via Panel. The filter button simply shows no results if the category is empty -- this is acceptable UX.

### Responsive Breakpoints
Follow the UI-SPEC exactly:
- Mobile (<640px): 2 columns
- Tablet (640-1023px): 3 columns
- Desktop (>=1024px): 4 columns
Using Tailwind: `columns-2 sm:columns-3 lg:columns-4`

## Environment Availability

| Dependency | Required By | Available | Version | Fallback |
|------------|------------|-----------|---------|----------|
| PHP | Kirby CMS runtime | Yes | 8.2.12 | -- |
| Node.js | Vite build | Yes | 22.16.0 | -- |
| npm | Package management | Yes | 10.9.2 | -- |
| GLightbox | Gallery lightbox | CDN (no install) | 3.3.1 | -- |

No missing dependencies. GLightbox is loaded via CDN, no local installation required.

## Sources

### Primary (HIGH confidence)
- Existing codebase: `site/snippets/sections/dish-card.php`, `site/snippets/sections/contact-map.php` (CDN loading pattern), `site/blueprints/pages/wines.yml` (structure field pattern)
- [GLightbox GitHub](https://github.com/biati-digital/glightbox) - API: elements array, setElements(), event listeners, CDN URLs
- [Kirby Files Section](https://getkirby.com/docs/reference/panel/sections/files) - Files section config, file blueprints, template association
- [Kirby Structure Field](https://getkirby.com/docs/reference/panel/fields/structure) - Structure field for events
- [cdnjs GLightbox](https://cdnjs.com/libraries/glightbox) - CDN URLs for version 3.3.1

### Secondary (MEDIUM confidence)
- [Kirby Forum: Filter by date](https://forum.getkirby.com/t/filter-by-date-field/25065) - `toDate()` + `time()` pattern for future/past filtering
- [Kirby Forum: Date in future](https://forum.getkirby.com/t/determine-if-date-from-date-field-is-in-the-future-or-today/30765) - Date comparison approach verified by community

## Metadata

**Confidence breakdown:**
- Standard stack: HIGH - All libraries already in project stack or established CDN pattern
- Architecture: HIGH - Follows exact patterns from Phase 1-2 (templates, blueprints, snippets, controllers)
- Pitfalls: HIGH - GLightbox filter issue verified through API docs, other pitfalls from established Kirby patterns

**Research date:** 2026-04-09
**Valid until:** 2026-05-09 (stable stack, no fast-moving dependencies)
