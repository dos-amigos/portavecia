# Architecture Patterns

**Domain:** Multilingual wine bar / enoteca website (Kirby CMS)
**Researched:** 2026-04-08

## Recommended Architecture

Kirby CMS uses a file-based, convention-over-configuration architecture. The system connects content, blueprints, templates, and controllers through **matching filenames**. A page folder named `wines` with content file `wines.it.txt` automatically links to blueprint `wines.yml`, template `wines.php`, and controller `wines.php`.

### Top-Level Directory Structure

```
portavecia/
  content/              # All site content (file-based, no DB)
  site/
    blueprints/         # Panel form definitions (YAML)
    controllers/        # Template logic (PHP)
    languages/          # Language definitions (IT, EN)
    models/             # Custom page models (PHP, optional)
    plugins/            # Kirby plugins
    snippets/           # Reusable HTML/PHP components
    templates/          # Page templates (PHP)
  assets/
    css/                # Stylesheets
    js/                 # JavaScript
    fonts/              # Custom fonts
    images/             # Static images (logo, icons, bg)
  kirby/                # Kirby core (do not modify)
  media/                # Auto-generated thumbnails (gitignored)
  index.php             # Entry point
  .htaccess             # Apache config
```

### Content Tree (Bilingual)

Content folders map directly to URLs. Numbered prefixes control sort order and visibility (published vs draft). Each page has two text files: `.it.txt` (default language) and `.en.txt`.

```
content/
  site.it.txt                           # Global site settings (IT)
  site.en.txt                           # Global site settings (EN)
  1_home/
    home.it.txt
    home.en.txt
    hero.jpg
  2_chi-siamo/
    about.it.txt                        # Template name = "about"
    about.en.txt
    locale-interno.jpg
    plateatico.jpg
  3_cucina/
    menu.it.txt                         # Template name = "menu"
    menu.en.txt
    piatto-ravioli.jpg
    piatto-involtini.jpg
  4_vini/
    wines.it.txt
    wines.en.txt
    vino-1/                             # Child pages for individual wines
      wine.it.txt
      wine.en.txt
      bottiglia.jpg
    vino-2/
      wine.it.txt
      wine.en.txt
      bottiglia.jpg
  5_galleria/
    gallery.it.txt
    gallery.en.txt
    foto-1.jpg
    foto-2.jpg
    ...
  6_eventi/
    events.it.txt
    events.en.txt
    evento-degustazione/                # Child pages for individual events
      event.it.txt
      event.en.txt
      locandina.jpg
  7_contatti/
    contact.it.txt
    contact.en.txt
```

### Blueprint Structure

```
site/blueprints/
  site.yml                    # Global site fields (name, social, hours, address, phone, whatsapp)
  pages/
    home.yml                  # Hero, intro sections, featured wines/dishes, CTA
    about.yml                 # Story, philosophy, image galleries
    menu.yml                  # Dish categories with structure fields
    wines.yml                 # Wine listing parent (children = individual wines)
    wine.yml                  # Single wine entry (name, year, region, notes, photo, price)
    gallery.yml               # Gallery page with files section
    events.yml                # Events listing parent
    event.yml                 # Single event (title, date, description, image)
    contact.yml               # Map embed, hours display, phone/whatsapp links
    default.yml               # Fallback for generic pages
  fields/
    dishes.yml                # Reusable structure: dish name, description, price
    seo.yml                   # Reusable: meta title, meta description, og image
  files/
    image.yml                 # Default image file blueprint (alt, caption)
```

### Template and Snippet Architecture

```
site/templates/
  home.php
  about.php
  menu.php
  wines.php
  wine.php
  gallery.php
  events.php
  event.php
  contact.php
  default.php

site/snippets/
  layout/
    header.php               # <head>, nav, language switch
    footer.php               # Footer with contacts, social, copyright
    nav.php                  # Main navigation (extracted for reuse)
  sections/
    hero.php                 # Hero banner (reused on home, about, etc.)
    cta-whatsapp.php         # WhatsApp/phone CTA buttons
    featured-wines.php       # Wine card grid (home page, wines page)
    featured-dishes.php      # Dish highlights (home page)
    gallery-grid.php         # Image grid with lightbox
    event-card.php           # Single event preview card
    testimonials.php         # Testimonials section (if added)
  components/
    wine-card.php            # Single wine card component
    dish-item.php            # Single dish row (name, desc, price)
    image-figure.php         # Responsive image with caption
    language-switch.php      # IT/EN toggle
    seo-meta.php             # Meta tags output
  blocks/                    # Kirby blocks (if using block editor)
    text.php
    image.php
    gallery.php

site/controllers/
  site.php                   # Global controller: shared data (hours, contact info, nav)
  home.php                   # Featured wines/dishes queries
  wines.php                  # Wine listing with optional filtering
  events.php                 # Events sorted by date, past/upcoming split
  gallery.php                # Image collection handling
```

## Component Boundaries

| Component | Responsibility | Communicates With |
|-----------|---------------|-------------------|
| **Content (files)** | Stores all data as flat text files + media | Read by Templates via Kirby API |
| **Blueprints (YAML)** | Define Panel editing forms, field types, validation | Configure Panel UI; mirror Content structure |
| **Controllers (PHP)** | Business logic, data queries, filtering | Read Content via Kirby API; pass variables to Templates |
| **Templates (PHP)** | Page-level HTML structure, include Snippets | Receive data from Controllers; compose Snippets |
| **Snippets (PHP)** | Reusable UI components | Receive data via parameters from Templates |
| **Languages (PHP)** | Define available languages, locale, URL prefix | Configure Kirby multilingual routing |
| **Assets (CSS/JS)** | Frontend styling and interactivity | Referenced by Snippets/Templates |
| **Kirby Panel** | Admin interface for content editors | Reads Blueprints, writes Content files |

### Data Flow

```
[Editor in Panel] --> writes --> [Content .txt files + images]
                                        |
                                        v
[HTTP Request] --> [Kirby Router] --> [Controller] --> queries --> [Content API]
                        |                  |
                        |                  v
                        |           [Template] --> includes --> [Snippets]
                        |                  |
                        v                  v
                   [Language            [HTML Response]
                    Detection]
```

**Read path (visitor):**
1. Request arrives, Kirby detects language from URL prefix (`/en/wines` vs `/vini`)
2. Router matches URL to content folder, loads correct `.it.txt` or `.en.txt`
3. Controller runs, queries child pages / structures, prepares data
4. Template renders page structure, calling snippets with data
5. Snippets output HTML components
6. Assets (CSS/JS) loaded in header/footer snippets

**Write path (editor):**
1. Editor logs into Kirby Panel
2. Panel reads blueprints to render form UI
3. Editor changes content, Panel writes to `.it.txt` / `.en.txt` files
4. Media uploads go into the page's content folder
5. No build step needed -- changes are live immediately

## Patterns to Follow

### Pattern 1: Convention-Based File Matching
**What:** Name content folders, blueprints, templates, and controllers identically.
**Why:** Kirby auto-discovers matching files. A content file `wines.it.txt` automatically uses `wines.yml` blueprint, `wines.php` template, and `wines.php` controller.
**Example:** For the wines listing page:
- Content: `/content/4_vini/wines.it.txt`
- Blueprint: `/site/blueprints/pages/wines.yml`
- Template: `/site/templates/wines.php`
- Controller: `/site/controllers/wines.php`

### Pattern 2: Reusable Blueprint Fields
**What:** Extract repeated field groups into `/site/blueprints/fields/` and reference with `extends`.
**Why:** Avoids duplication. The dishes structure field, SEO fields, and common image fields appear across multiple blueprints.
**Example:**
```yaml
# site/blueprints/fields/dishes.yml
label: Dishes
type: structure
fields:
  dish:
    label: Dish
    type: text
    width: 1/3
  description:
    label: Description
    type: text
    width: 1/3
  price:
    label: Price
    type: number
    before: "$"
    step: 0.01
    width: 1/3
```
```yaml
# In menu.yml
fields:
  antipasti:
    extends: fields/dishes
    label: Antipasti
  primi:
    extends: fields/dishes
    label: Primi
```

### Pattern 3: Site Controller for Global Data
**What:** Use `/site/controllers/site.php` to provide shared data (opening hours, contact info, social links) to all templates.
**Why:** Avoids repeating `$site->phone()` calls in every template. Footer and header snippets get clean variables.
**Example:**
```php
// site/controllers/site.php
return function ($site) {
    return [
        'phone'    => $site->phone(),
        'whatsapp' => $site->whatsapp(),
        'hours'    => $site->hours()->toStructure(),
        'social'   => $site->social()->toStructure(),
    ];
};
```

### Pattern 4: Snippet Subfolder Organization
**What:** Organize snippets into `layout/`, `sections/`, and `components/` subfolders.
**Why:** Flat snippet folders become unmanageable quickly. This three-tier organization separates page chrome (layout), page sections (sections), and atomic UI elements (components).

### Pattern 5: Language Variables for UI Strings
**What:** Store static UI text (button labels, section headings) in language variable files, not in content.
**Why:** UI strings like "Read more", "Our wines", "Book now" should not burden editors. Use `t('book_now')` in templates.
**Example:**
```php
// site/languages/it.php
return [
    'code' => 'it',
    'default' => true,
    'name' => 'Italiano',
    'locale' => 'it_IT.utf8',
    'translations' => [
        'book_now' => 'Prenota ora',
        'read_more' => 'Scopri di più',
        'our_wines' => 'I nostri vini',
    ],
];
```

### Pattern 6: Child Pages vs Structure Fields
**What:** Use child pages for content that needs its own URL, detail view, or rich media (wines, events). Use structure fields for simpler list data that lives on one page (menu dishes, opening hours).
**Why:** Wines and events each have a detail page with photo, description, and unique URL (good for SEO and sharing). Menu dishes are listed inline -- no one links to a single dish.

## Anti-Patterns to Avoid

### Anti-Pattern 1: Hardcoded Text in Templates
**What:** Writing Italian/English strings directly in PHP templates.
**Why bad:** Breaks multilingual support. Every hardcoded string needs to be duplicated and maintained in two places.
**Instead:** Use `t('key')` for UI strings. Use content fields for editable text.

### Anti-Pattern 2: Logic in Templates
**What:** Complex queries, filtering, or data manipulation inside `.php` templates.
**Why bad:** Templates become unreadable. Harder to debug and maintain.
**Instead:** Move all logic to controllers. Templates should only loop, output, and include snippets.

### Anti-Pattern 3: Monolithic Blueprints
**What:** One huge blueprint with all fields at the top level, no tabs or sections.
**Why bad:** Panel becomes overwhelming for editors. Hard to find fields.
**Instead:** Use tabs to group related content (e.g., Content tab, SEO tab, Settings tab). Use `extends` for reusable field groups.

### Anti-Pattern 4: Flat Snippet Directory
**What:** All snippets in `/site/snippets/` root with no subfolders.
**Why bad:** 20+ files become hard to navigate. No clear hierarchy.
**Instead:** Use `layout/`, `sections/`, `components/` subfolders.

### Anti-Pattern 5: Using Structure Fields for Everything
**What:** Storing wines and events as structure fields on a single page instead of child pages.
**Why bad:** No individual URLs, no SEO for individual items, limited media handling, harder to manage large lists.
**Instead:** Use child pages with their own blueprints for content that deserves a detail view.

## Multilingual Architecture Details

### Language Configuration

```
site/languages/
  it.php    # Default language (Italian)
  en.php    # Secondary language (English)
```

Italian as default because: the primary audience is local (Este, Padova area), and the existing content will be written in Italian first. English is the secondary translation.

### URL Structure

| Language | URL Pattern | Example |
|----------|-------------|---------|
| Italian (default) | `/pagina` | `/vini`, `/chi-siamo`, `/contatti` |
| English | `/en/page` | `/en/wines`, `/en/about`, `/en/contact` |

Italian gets root URLs (no `/it/` prefix) because it is the primary audience. English gets `/en/` prefix.

### Translation Strategy

| Content Type | Translation Approach |
|-------------|---------------------|
| Page content (hero text, descriptions) | Separate `.it.txt` / `.en.txt` files, fully translated |
| Menu dish names/descriptions | Translated via structure field content in each language file |
| Wine names | `translate: false` (wine names don't change) |
| Wine tasting notes | Translated |
| UI labels (buttons, headings) | Language variables via `t()` helper |
| Image alt text / captions | Translated via file metadata `.it.txt` / `.en.txt` |
| Prices, phone numbers, addresses | `translate: false` (shared across languages) |

## Frontend Architecture (Candore-Inspired)

### CSS Organization

```
assets/
  css/
    main.css              # Entry point, imports all partials
    base/
      reset.css           # CSS reset / normalize
      typography.css      # Font faces, type scale, headings
      variables.css       # CSS custom properties (colors, spacing, fonts)
    layout/
      grid.css            # Grid system, containers
      header.css          # Sticky header, nav
      footer.css          # Footer layout
    components/
      buttons.css         # CTA buttons, WhatsApp button
      cards.css           # Wine cards, event cards
      hero.css            # Hero sections
      gallery.css         # Gallery grid + lightbox
      menu-list.css       # Menu/dish list styling
    pages/
      home.css            # Home-specific overrides
    utilities/
      responsive.css      # Media queries, breakpoints
      animations.css      # Scroll animations, transitions
```

### JavaScript (Minimal)

```
assets/
  js/
    main.js               # Entry: init all modules
    modules/
      navigation.js       # Mobile menu toggle, sticky header
      gallery.js          # Lightbox initialization
      scroll.js           # Smooth scroll, scroll animations
      language-switch.js  # Language toggle (if any JS needed)
```

No build tools required for a site this size. Plain CSS custom properties for theming, vanilla JS for interactions. If a build step is later desired, Vite can be added without restructuring.

### Design Token Strategy (CSS Custom Properties)

```css
:root {
  /* Candore-inspired palette */
  --color-primary: #c8a97e;      /* Gold accent */
  --color-dark: #1a1a1a;         /* Near-black backgrounds */
  --color-light: #f5f0eb;        /* Warm off-white */
  --color-text: #333333;         /* Body text */
  --color-text-light: #999999;   /* Secondary text */

  --font-heading: 'Playfair Display', serif;
  --font-body: 'Raleway', sans-serif;

  --spacing-section: 6rem;
  --max-width: 1200px;
}
```

## Scalability Considerations

| Concern | Current Scale (launch) | Growth (50+ wines, 20+ events) |
|---------|----------------------|-------------------------------|
| Content volume | Flat-file is fast for <100 pages | Still fine; Kirby handles hundreds of pages well |
| Image management | Store in page folders | Add image optimization plugin (e.g., kirby-imageoptim) |
| Panel usability | Simple field layouts | Add tabs, use structure fields wisely, keep blueprints clean |
| Caching | Not needed initially | Enable Kirby page cache for production (`'cache' => ['pages' => ['active' => true]]`) |
| Search | Not needed for v1 | Kirby's built-in search or Algolia plugin if needed later |

## Suggested Build Order

Dependencies flow downward. Each layer depends on the one above it.

```
Phase 1: Foundation
  [Language Config] + [Site Blueprint] + [Layout Snippets (header/footer)]
  WHY FIRST: Everything else depends on multilingual routing and global layout.

Phase 2: Content Model
  [All Page Blueprints] + [Reusable Field Blueprints] + [Content Folder Structure]
  WHY SECOND: Templates cannot be built without content to render. Blueprints
  define what data exists. Content folders with sample data enable template development.

Phase 3: Templates + Controllers
  [Controllers] + [Templates] + [Section Snippets] + [Component Snippets]
  WHY THIRD: With content model in place, build page-by-page:
    3a: Home (depends on featured wines/dishes, so build after wines/menu blueprints)
    3b: About (simple, few dependencies)
    3c: Menu/Cucina (depends on dishes structure field)
    3d: Wines + single Wine (parent-child pattern, reusable wine-card snippet)
    3e: Gallery (depends on file blueprints, gallery-grid snippet)
    3f: Events + single Event (parent-child pattern, event-card snippet)
    3g: Contact (depends on site.yml global fields for hours/address)

Phase 4: Frontend Polish
  [CSS Architecture] + [JS Modules] + [Responsive Tuning] + [Animations]
  WHY FOURTH: Styling builds on top of the HTML structure from templates/snippets.

Phase 5: Production Readiness
  [SEO meta snippets] + [Caching config] + [Image optimization] + [.htaccess]
  WHY LAST: Polish and performance after functionality is complete.
```

**Critical dependency:** Language configuration MUST be done before any content files are created. Kirby renames all content files when languages are enabled, so enabling it after content exists causes unnecessary file migration.

## Sources

- [Kirby Blueprints Reference](https://getkirby.com/docs/reference/panel/blueprints)
- [Structuring Blueprints](https://getkirby.com/docs/guide/blueprints/layout)
- [Restaurant Menu Sample](https://getkirby.com/docs/reference/panel/samples/menu)
- [Multi-language Guide](https://getkirby.com/docs/guide/languages)
- [Translating Content](https://getkirby.com/docs/guide/languages/translating-content)
- [Switching Languages](https://getkirby.com/docs/guide/languages/switching-languages)
- [Custom Language Variables](https://getkirby.com/docs/guide/languages/custom-language-variables)
- [Exploring the Starterkit](https://getkirby.com/docs/guide/tour)
- [Snippets Guide](https://getkirby.com/docs/guide/templates/snippets)
- [Controllers Guide](https://getkirby.com/docs/guide/templates/controllers)
- [Reusing & Extending Blueprints](https://getkirby.com/docs/guide/blueprints/extending-blueprints)
- [Candore Template Demo](https://duruthemes.com/demo/html/candore/demo1/)
