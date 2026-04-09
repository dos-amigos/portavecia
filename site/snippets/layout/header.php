<!DOCTYPE html>
<html lang="<?= $kirby->language()->code() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page->title() ?> | <?= $site->title() ?></title>
  <?= vite()->css('src/js/main.js') ?>
</head>
<body class="font-body bg-dark text-light pt-20">

<header x-data="{ mobileOpen: false }" class="fixed top-0 w-full z-50 bg-dark border-b border-light/10">
  <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-20">

    <!-- Logo -->
    <a href="<?= $site->url() ?>" class="font-heading text-2xl text-primary hover:text-primary-dark transition-colors">
      Porta Vecia
    </a>

    <!-- Desktop nav -->
    <nav class="hidden md:flex items-center gap-6" aria-label="Main">
      <a href="<?= $site->find('home') ? $site->find('home')->url() : $site->url() ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.home') ?></a>
      <a href="<?= ($p = $site->find('about')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.about') ?></a>
      <a href="<?= ($p = $site->find('menu')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.menu') ?></a>
      <a href="<?= ($p = $site->find('wines')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.wines') ?></a>
      <a href="<?= ($p = $site->find('gallery')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-sm uppercase tracking-wider font-body transition-colors"><?= t('nav.gallery') ?></a>
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

  <!-- Mobile nav panel -->
  <nav
    x-show="mobileOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    x-cloak
    class="md:hidden bg-dark border-t border-light/10"
    aria-label="Mobile"
  >
    <div class="max-w-6xl mx-auto px-4 py-6 flex flex-col gap-4">
      <a @click="mobileOpen = false" href="<?= $site->find('home') ? $site->find('home')->url() : $site->url() ?>" class="text-light/80 hover:text-primary text-base uppercase tracking-wider font-body transition-colors"><?= t('nav.home') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('about')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-base uppercase tracking-wider font-body transition-colors"><?= t('nav.about') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('menu')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-base uppercase tracking-wider font-body transition-colors"><?= t('nav.menu') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('wines')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-base uppercase tracking-wider font-body transition-colors"><?= t('nav.wines') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('gallery')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-base uppercase tracking-wider font-body transition-colors"><?= t('nav.gallery') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('events')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-base uppercase tracking-wider font-body transition-colors"><?= t('nav.events') ?></a>
      <a @click="mobileOpen = false" href="<?= ($p = $site->find('contact')) ? $p->url() : '#' ?>" class="text-light/80 hover:text-primary text-base uppercase tracking-wider font-body transition-colors"><?= t('nav.contact') ?></a>

      <div class="pt-4 border-t border-light/10">
        <?php snippet('components/language-switch') ?>
      </div>
    </div>
  </nav>
</header>
