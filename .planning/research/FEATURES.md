# Feature Landscape

**Domain:** Wine bar / enoteca website with Italian wine + Chinese cuisine fusion
**Researched:** 2026-04-08

## Table Stakes

Features users expect. Missing = product feels incomplete or unprofessional.

| Feature | Why Expected | Complexity | Notes |
|---------|--------------|------------|-------|
| Responsive design | 60%+ visitors will be mobile (searching "wine bar near me" or browsing while walking in Este) | Medium | Candore template is already responsive; maintain this through Kirby implementation |
| Sticky header navigation | Users need persistent access to pages; standard on every restaurant/bar site | Low | Logo left, nav links center/right, language switch, CTA button |
| Hero section with strong imagery | First impression defines whether users stay; wine/food sites live or die by visuals | Medium | Full-bleed photo or short video loop of the locale, wine glasses, food. Clear value proposition overlay. |
| About / Chi Siamo page | Trust builder; visitors want to know who runs the place and the story behind it | Low | Story of the owners, the fusion concept origin, photos of the interior/plateatico, the historic Este location |
| Menu / Cucina page | #1 reason people visit restaurant websites; no menu = immediate bounce | Medium | HTML-native menu (NOT PDF). Categories: antipasti, ravioli, involtini, spaghetti, other dishes. Name + description + price per item. Candore menubook style. |
| Wine showcase page | Core identity of an enoteca; visitors expect to see what wines are available | Medium | Curated selection (not full catalog). Card grid: bottle photo, name, origin, tasting notes, price. Candore wine page style. |
| Contact / Location page | Users need address, hours, phone, how to get there | Low | Embedded map (Google Maps or OpenStreetMap), opening hours, phone number, WhatsApp button, address with directions |
| Opening hours display | Among the top 3 things people search for about restaurants | Low | Prominent on contact page AND footer. Editable from Kirby backend. |
| WhatsApp / Phone CTA buttons | Direct booking channel as specified; users expect easy contact | Low | Floating or fixed WhatsApp button, tel: links. One-tap on mobile. |
| Footer with essential info | Standard web convention; users scroll to footer for quick contact info | Low | Address, hours, phone, social links, language switch, copyright |
| Social media links | Users expect to find Instagram/Facebook for latest photos and updates | Low | Icons in header and/or footer linking to social profiles |
| Bilingual IT/EN with language switch | Este has tourism; English visitors need accessible content | Medium | Kirby's built-in multi-language system. Subdirectory structure (/en/) for SEO. hreflang tags. Full translation including meta tags. |
| Local SEO fundamentals | "Enoteca Este" / "wine bar Este" searches must find this site | Low | Meta titles/descriptions per page, structured data (LocalBusiness schema), Google Business Profile link, proper address markup |
| Photo gallery | Visual proof of atmosphere, food quality, locale charm | Medium | Lightbox grid (Candore gallery style). Categories: locale, piatti, vini, eventi. Manageable from Kirby. |
| Cookie consent / Privacy | GDPR requirement for Italian websites | Low | Simple banner, link to privacy policy. Required by law. |

## Differentiators

Features that set Porta Vecia apart. Not expected, but create competitive advantage.

| Feature | Value Proposition | Complexity | Notes |
|---------|-------------------|------------|-------|
| Fusion concept storytelling section | THE unique selling point. A dedicated visual narrative explaining why Italian wine + Chinese homemade food works together. This is what makes Porta Vecia memorable. | Medium | Could be a section on homepage or its own "Features" page (Candore features style with numbered blocks and alternating images). Tell the story: Italian aperitivo tradition meets authentic Chinese handmade cuisine. Show the parallels: both cultures revere food craftsmanship, both have rich traditions of noodles/pasta. |
| Food + Wine pairing suggestions | Elevate beyond "here's our menu" to "here's the experience." Suggest which wines pair with which dishes. | Low | Simple implementation: on the menu page, add pairing notes ("Pairs beautifully with our Chianti Classico"). On wine page, note food matches. Does not need to be algorithmic -- just editorial suggestions managed in Kirby. |
| Events / Serate speciali page | Builds community, gives reasons to return, positions Porta Vecia as a destination | Medium | Upcoming events list with date, description, image. Past events gallery. Degustazioni, serate a tema, seasonal specials. Editable from Kirby. |
| Atmospheric video or animation on hero | Video of wine being poured, steam rising from ravioli, the plateatico at golden hour -- creates emotional pull | Medium | Short loop (10-15s), muted autoplay, with fallback image. Must be optimized for performance (compressed, lazy-loaded). |
| "L'Esperienza" / Experience section on homepage | Instead of just listing menu items, frame the visit as an experience: arrive, sit in the plateatico or intimate interior, browse wines, discover homemade Chinese dishes, enjoy the pairing | Low | 3-4 step visual storytelling block on homepage. Icons or photos with short text. Guides the visitor through what an evening at Porta Vecia feels like. |
| Seasonal highlights / Piatto del momento | Dynamic content that gives returning visitors something new; shows the place is alive and active | Low | A small featured section on homepage: "This week's highlight" with a dish or wine. Easily updated from Kirby backend. |
| Google Reviews integration | Social proof without building a review system | Low | Display a few curated Google Reviews quotes on homepage or about page. Manual curation (not API) to keep it simple and avoid dependencies. |
| Structured data for rich search results | Enhanced Google search appearance with stars, hours, price range | Low | JSON-LD schema: LocalBusiness, Restaurant, OpeningHoursSpecification. Helps with "near me" searches and Google Maps. |

## Anti-Features

Features to explicitly NOT build.

| Anti-Feature | Why Avoid | What to Do Instead |
|--------------|-----------|-------------------|
| E-commerce / online wine shop | Out of scope. The goal is getting people INTO the locale, not shipping bottles. Adds enormous complexity (payments, inventory, shipping). | Showcase wines with descriptions. CTA: "Vieni a scoprirli" / "Come taste them" |
| Online reservation form | Client explicitly wants WhatsApp/phone. Forms create backend complexity, email deliverability issues, and feel impersonal for a small intimate enoteca. | WhatsApp button (wa.me link with prefilled message) + phone number. One-tap on mobile. More personal, more Italian. |
| Full wine catalog with filters | Overkill for a small enoteca. Maintaining a large database is a burden. The charm is curation, not quantity. | Curated "vetrina" of 8-15 featured wines, rotated seasonally from Kirby backend |
| Blog / news section | Client said not needed for v1. Creates content maintenance burden with little ROI for a local venue. | Events page handles "what's new." Social media handles updates. |
| User accounts / loyalty program | Way too complex for a single-location enoteca website. Zero ROI. | Loyalty handled in person at the bar, as Italian venues traditionally do |
| Integrated review system | Legal complexity, moderation burden, and users already use Google/TripAdvisor. | Link to Google Reviews. Optionally display curated quotes. |
| Complex animations / parallax overload | Slows performance, hurts mobile experience, distracts from content. Candore is elegant, not flashy. | Subtle transitions (fade-in on scroll), quality photography, clean typography. Let the content breathe. |
| AI-powered wine recommendation chatbot | Gimmicky, expensive to maintain, inappropriate for the scale and warmth of this venue. | Human touch: editorial pairing suggestions on menu/wine pages |
| PDF menu download | Bad for SEO, inaccessible, hard to update, poor mobile experience. | HTML-native menu that's searchable, responsive, and easy to update from Kirby |
| Multi-location support | Single venue. Don't over-engineer the CMS structure. | Simple single-location site structure |

## Feature Dependencies

```
Bilingual system (IT/EN) → ALL content pages (must be built bilingual from day 1)
Kirby CMS setup → ALL editable content (menu, wines, events, gallery, hours)
Photo gallery infrastructure → Events page (past events use gallery)
Menu page → Food+wine pairing suggestions (pairings reference menu items)
Wine page → Food+wine pairing suggestions (pairings reference wines)
Hero section → Atmospheric video (optional enhancement to hero)
Contact page → WhatsApp/Phone CTA (also appears as floating button site-wide)
Local SEO setup → Structured data, meta tags, hreflang (foundational, do early)
```

## MVP Recommendation

**Phase 1 -- Core (Must ship first):**
1. Responsive multi-page structure with sticky navigation
2. Homepage with hero, fusion concept teaser, wine/food preview, CTA
3. Menu page (HTML-native, bilingual, Candore menubook style)
4. Wine showcase page (curated selection, Candore wine style)
5. Contact/Location page with map, hours, WhatsApp/phone buttons
6. About page with story, photos, fusion concept explanation
7. Bilingual IT/EN with language switch
8. Local SEO fundamentals (meta tags, structured data, hreflang)
9. Footer with essential info
10. Cookie consent

**Phase 2 -- Engagement (Ship shortly after):**
1. Photo gallery with lightbox
2. Events page for degustazioni and serate speciali
3. Food + wine pairing suggestions on menu/wine pages
4. Google Reviews quotes on homepage
5. Seasonal highlights / featured dish section

**Phase 3 -- Polish (Refinement):**
1. Atmospheric video hero (once good video footage is available)
2. "L'Esperienza" storytelling section
3. Performance optimization (image compression, lazy loading)
4. Advanced structured data (FAQ schema, Event schema)

**Defer indefinitely:** E-commerce, blog, user accounts, chatbot, PDF menu.

## Creative Fusion Concept Presentation

The Italian wine + Chinese homemade cuisine fusion is the single biggest differentiator. Research on successful fusion restaurants (Sesamo NYC, Asia Roma, DaVinci & Yu) reveals key principles:

**Narrative approach -- "Two Traditions, One Table":**
- Frame the fusion around shared values: both Italian and Chinese cultures revere handmade food, fresh ingredients, centuries of culinary tradition
- The parallel of pasta/noodles, ravioli/dumplings is a natural storytelling hook
- Avoid the word "fusion" if possible -- it can feel gimmicky. Instead: "authentic homemade Chinese cuisine paired with quality Italian wines" feels more genuine

**Visual approach:**
- Side-by-side or alternating imagery: a wine glass next to handmade ravioli, Italian aperitivo setting with Chinese delicacies
- Candore's "features" page with numbered alternating blocks is perfect for this: Block 1: "The Wine" (Italian tradition), Block 2: "The Cuisine" (Chinese handmade tradition), Block 3: "The Experience" (the pairing, the evening)
- Color palette that bridges both cultures: deep wine reds, warm golds, clean whites

**Content approach:**
- "Fatto a mano" / "Handmade" as the connecting thread -- wines crafted by artisans, food made by hand every day
- Highlight specific pairings: "Our handmade jiaozi with a glass of Valpolicella"
- Use the historic Este location as the third character in the story: Italian town, Chinese craft, timeless quality

## Sources

- [Colorlib - Wine Website Templates 2026](https://colorlib.com/wp/wine-website-templates/)
- [Paige Madden - 5 Must-Have Features for Restaurant Websites](https://www.paigemaddendesign.com/blog/5-must-have-features-for-a-restaurant-website-that-converts)
- [SiteBuilderReport - Bar Websites 2026](https://www.sitebuilderreport.com/inspiration/bar-websites)
- [Mediaboom - Wine Website Design Ideas 2025](https://mediaboom.com/news/wine-website-design/)
- [Highway 29 Creative - Winery Website UX Best Practices](https://www.hwy29creative.com/blog/best-practices-for-winery-website-user-experience)
- [Prismic - Hero Section Best Practices](https://prismic.io/blog/website-hero-section)
- [Weglot - Multilingual SEO Guide](https://www.weglot.com/guides/multilingual-seo-tips)
- [Google - Managing Multi-Regional Sites](https://developers.google.com/search/docs/specialty/international/managing-multi-regional-sites)
- [Sesamo NYC - Italian Asian Fusion](https://sesamorestaurant.com/italian-asian-fusion-restaurant-in-ny/)
- [PhillyMag - DaVinci & Yu Italian-Asian Restaurant](https://www.phillymag.com/foobooz/2025/02/18/davinci-and-yu-italian-asian-restaurant-east-passyunk/)
- [Toast - Wine Menu Design](https://pos.toasttab.com/blog/on-the-line/wine-menu-design)
- [Candore Template Demo](https://duruthemes.com/demo/html/candore/demo1/)
