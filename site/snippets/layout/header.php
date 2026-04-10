<!DOCTYPE html>
<html lang="<?= $kirby->language()->code() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page->customtitle()->or($page->title()) ?> | <?= $site->title() ?></title>

  <?= $page->meta()->robots() ?>
  <?= $page->meta()->social() ?>
  <?= $page->meta()->jsonld() ?>

  <?php foreach ($kirby->languages() as $lang): ?>
  <link rel="alternate" hreflang="<?= $lang->code() ?>" href="<?= $page->url($lang->code()) ?>" />
  <?php endforeach ?>
  <link rel="alternate" hreflang="x-default" href="<?= $page->url($kirby->defaultLanguage()->code()) ?>" />

  <?= vite()->css('src/js/main.js') ?>
</head>
<body class="font-body bg-dark text-light pt-20">

<header x-data="{ mobileOpen: false }" class="fixed top-0 w-full z-50 bg-dark border-b border-light/10">
  <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-20">

    <!-- Logo: tower + text -->
    <a href="<?= $site->url() ?>" class="hover:opacity-80 transition-opacity flex items-center gap-2 shrink-0">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 48" fill="none" class="h-8 w-auto">
        <g stroke="var(--color-primary)" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" fill="none">
          <rect x="8" y="20" width="20" height="24" rx="1"/>
          <rect x="10" y="12" width="16" height="10" rx="1"/>
          <rect x="12" y="5" width="12" height="9" rx="1"/>
          <line x1="18" y1="0" x2="18" y2="5"/>
          <circle cx="18" cy="16" r="3"/>
          <line x1="18" y1="14" x2="18" y2="16"/>
          <line x1="18" y1="16" x2="19.5" y2="17"/>
          <path d="M15 44 L15 38 A3 3 0 0 1 21 38 L21 44"/>
          <rect x="13" y="23" width="3" height="4" rx="0.5"/>
          <rect x="20" y="23" width="3" height="4" rx="0.5"/>
          <line x1="12" y1="5" x2="12" y2="3"/><line x1="15" y1="5" x2="15" y2="3"/>
          <line x1="21" y1="5" x2="21" y2="3"/><line x1="24" y1="5" x2="24" y2="3"/>
        </g>
      </svg>
      <span class="font-heading text-3xl whitespace-nowrap" style="-webkit-text-stroke: 1px var(--color-light); color: transparent">Porta Vecia</span>
    </a>

    <!-- Desktop nav -->
    <nav class="hidden md:flex items-center gap-6" aria-label="Main">
      <a href="<?= $site->find('home') ? $site->find('home')->url() : $site->url() ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.home') ?></a>
      <a href="<?= ($p = $site->find('about')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.about') ?></a>
      <a href="<?= ($p = $site->find('menu')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.menu') ?></a>
      <a href="<?= ($p = $site->find('wines')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.wines') ?></a>
      <a href="<?= ($p = $site->find('events')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.events') ?></a>
      <a href="<?= ($p = $site->find('contact')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.contact') ?></a>
    </nav>

    <!-- Desktop language switch -->
    <div class="hidden md:block">
      <?php snippet('components/language-switch') ?>
    </div>

    <!-- Mobile hamburger button -->
    <button
      @click="mobileOpen = !mobileOpen"
      class="md:hidden text-light p-2"
      :aria-expanded="mobileOpen"
      aria-label="Menu"
    >
      <!-- Hamburger icon -->
      <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <!-- Close icon -->
      <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Mobile nav fullscreen overlay -->
  <nav
    x-show="mobileOpen"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @keydown.escape.window="mobileOpen = false"
    x-cloak
    class="md:hidden fixed inset-0 z-40 flex flex-col items-center justify-center"
    style="background: rgba(10, 10, 14, 0.92); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px)"
    aria-label="Mobile"
  >
    <!-- Logo in white at top -->
    <div class="absolute top-6 left-1/2 -translate-x-1/2 flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 48" fill="none" class="h-8 w-auto">
        <g stroke="var(--color-primary)" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" fill="none">
          <rect x="8" y="20" width="20" height="24" rx="1"/>
          <rect x="10" y="12" width="16" height="10" rx="1"/>
          <rect x="12" y="5" width="12" height="9" rx="1"/>
          <line x1="18" y1="0" x2="18" y2="5"/>
          <circle cx="18" cy="16" r="3"/>
          <line x1="18" y1="14" x2="18" y2="16"/>
          <line x1="18" y1="16" x2="19.5" y2="17"/>
          <path d="M15 44 L15 38 A3 3 0 0 1 21 38 L21 44"/>
          <rect x="13" y="23" width="3" height="4" rx="0.5"/>
          <rect x="20" y="23" width="3" height="4" rx="0.5"/>
          <line x1="12" y1="5" x2="12" y2="3"/><line x1="15" y1="5" x2="15" y2="3"/>
          <line x1="21" y1="5" x2="21" y2="3"/><line x1="24" y1="5" x2="24" y2="3"/>
        </g>
      </svg>
      <span class="font-heading text-3xl text-light">Porta Vecia</span>
    </div>

    <!-- Close button -->
    <button
      @click="mobileOpen = false"
      class="absolute top-6 right-5 text-light hover:text-primary transition-colors p-2 z-50"
      aria-label="Close menu"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <!-- Nav links -->
    <div class="flex flex-col items-center gap-7">
      <a @click="mobileOpen = false" href="<?= $site->find('home') ? $site->find('home')->url() : $site->url() ?>"
         class="text-light hover:text-primary font-heading text-3xl tracking-wide transition-colors duration-300"
         x-show="mobileOpen" x-transition:enter="transition ease-out duration-500 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
      ><?= t('nav.home') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('about')) ? $p->url() : '#' ?>"
         class="text-light hover:text-primary font-heading text-3xl tracking-wide transition-colors duration-300"
         x-show="mobileOpen" x-transition:enter="transition ease-out duration-500 delay-150" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
      ><?= t('nav.about') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('menu')) ? $p->url() : '#' ?>"
         class="text-light hover:text-primary font-heading text-3xl tracking-wide transition-colors duration-300"
         x-show="mobileOpen" x-transition:enter="transition ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
      ><?= t('nav.menu') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('wines')) ? $p->url() : '#' ?>"
         class="text-light hover:text-primary font-heading text-3xl tracking-wide transition-colors duration-300"
         x-show="mobileOpen" x-transition:enter="transition ease-out duration-500 delay-[250ms]" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
      ><?= t('nav.wines') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('events')) ? $p->url() : '#' ?>"
         class="text-light hover:text-primary font-heading text-3xl tracking-wide transition-colors duration-300"
         x-show="mobileOpen" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
      ><?= t('nav.events') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('contact')) ? $p->url() : '#' ?>"
         class="text-light hover:text-primary font-heading text-3xl tracking-wide transition-colors duration-300"
         x-show="mobileOpen" x-transition:enter="transition ease-out duration-500 delay-[350ms]" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
      ><?= t('nav.contact') ?></a>
    </div>

    <!-- Language switch -->
    <div class="mt-10" x-show="mobileOpen" x-transition:enter="transition ease-out duration-500 delay-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
      <?php snippet('components/language-switch') ?>
    </div>
  </nav>
</header>
