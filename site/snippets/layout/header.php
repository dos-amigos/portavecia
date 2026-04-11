<!DOCTYPE html>
<html lang="<?= $kirby->language()->code() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
<body x-data="{ mobileOpen: false }" class="font-body bg-dark text-light pt-20">

<header class="fixed top-0 w-full z-50 bg-dark border-b border-light/10">
  <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-20">

    <!-- Logo: tower + text -->
    <a href="<?= $site->url() ?>" class="hover:opacity-80 transition-opacity flex items-center gap-2 shrink-0">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 44" fill="none" class="h-7 w-auto">
        <g stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" fill="none">
          <rect x="6" y="16" width="16" height="24" rx="0.5"/>
          <rect x="8" y="10" width="12" height="8" rx="0.5"/>
          <line x1="8" y1="10" x2="8" y2="7"/>
          <line x1="11" y1="10" x2="11" y2="7"/>
          <line x1="14" y1="10" x2="14" y2="5"/>
          <line x1="17" y1="10" x2="17" y2="7"/>
          <line x1="20" y1="10" x2="20" y2="7"/>
          <path d="M12 40 L12 35 A2 2 0 0 1 16 35 L16 40"/>
          <rect x="9" y="20" width="2.5" height="3.5" rx="0.8"/>
          <rect x="16.5" y="20" width="2.5" height="3.5" rx="0.8"/>
          <rect x="9" y="26" width="2.5" height="3.5" rx="0.8"/>
          <rect x="16.5" y="26" width="2.5" height="3.5" rx="0.8"/>
        </g>
      </svg>
      <span class="font-logo text-3xl whitespace-nowrap text-light">Porta Vecia</span>
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
</header>

<!-- Mobile nav fullscreen overlay — FUORI dal header per evitare problemi di z-index -->
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
  class="md:hidden fixed inset-0 flex flex-col items-center justify-center"
  style="z-index: 9998; background: #0a0a0e"
  aria-label="Mobile"
>
  <!-- Logo in white at top -->
  <div class="absolute top-6 left-1/2 flex items-center gap-2" style="transform: translateX(-50%)">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 44" fill="none" class="h-7 w-auto">
      <g stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" fill="none">
        <rect x="6" y="16" width="16" height="24" rx="0.5"/>
        <rect x="8" y="10" width="12" height="8" rx="0.5"/>
        <line x1="8" y1="10" x2="8" y2="7"/>
        <line x1="11" y1="10" x2="11" y2="7"/>
        <line x1="14" y1="10" x2="14" y2="5"/>
        <line x1="17" y1="10" x2="17" y2="7"/>
        <line x1="20" y1="10" x2="20" y2="7"/>
        <path d="M12 40 L12 35 A2 2 0 0 1 16 35 L16 40"/>
        <rect x="9" y="20" width="2.5" height="3.5" rx="0.8"/>
        <rect x="16.5" y="20" width="2.5" height="3.5" rx="0.8"/>
        <rect x="9" y="26" width="2.5" height="3.5" rx="0.8"/>
        <rect x="16.5" y="26" width="2.5" height="3.5" rx="0.8"/>
      </g>
    </svg>
    <span class="font-logo text-3xl text-light">Porta Vecia</span>
  </div>

  <!-- Close button -->
  <button
    @click="mobileOpen = false"
    class="absolute top-6 right-5 text-light hover:text-primary transition-colors p-2"
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
