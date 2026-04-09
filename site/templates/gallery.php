<?php snippet('layout/header') ?>
<main>
  <!-- Page header -->
  <section class="section-padding bg-dark">
    <div class="container-site text-center">
      <h1 class="font-heading text-4xl md:text-5xl text-primary mb-4"><?= $page->headline() ?></h1>
      <?php if ($page->intro()->isNotEmpty()): ?>
        <p class="text-light/70 text-lg max-w-2xl mx-auto"><?= $page->intro() ?></p>
      <?php endif ?>
    </div>
  </section>

  <!-- Gallery with filters and lightbox -->
  <section class="section-padding" x-data="galleryFilter()">

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.1/css/glightbox.min.css" />

    <!-- Filter bar -->
    <div class="container-site mb-8">
      <div class="flex flex-wrap justify-center gap-2">
        <?php
        $filters = [
          'all'     => t('gallery.filter.all'),
          'locale'  => t('gallery.filter.locale'),
          'piatti'  => t('gallery.filter.piatti'),
          'vini'    => t('gallery.filter.vini'),
          'cucina'  => t('gallery.filter.cucina'),
          'eventi'  => t('gallery.filter.eventi'),
        ];
        foreach ($filters as $key => $label): ?>
          <button
            @click="setFilter('<?= $key ?>')"
            :class="activeFilter === '<?= $key ?>'
              ? 'px-4 py-2 text-sm font-bold text-dark bg-primary rounded-full uppercase tracking-wider'
              : 'px-4 py-2 text-sm font-bold text-light/70 bg-dark/50 border border-light/10 rounded-full uppercase tracking-wider cursor-pointer transition-colors hover:text-light'"
          >
            <?= $label ?>
          </button>
        <?php endforeach ?>
      </div>
    </div>

    <!-- Masonry grid -->
    <div class="container-site">
      <?php if ($page->images()->count() > 0): ?>
        <div class="gallery-grid columns-2 sm:columns-3 lg:columns-4 gap-3">
          <?php foreach ($page->images()->sortBy('sort') as $image): ?>
            <div
              class="break-inside-avoid mb-3"
              x-show="activeFilter === 'all' || '<?= $image->category()->value() ?: 'locale' ?>' === activeFilter"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
            >
              <a
                href="<?= $image->url() ?>"
                class="glightbox block rounded-lg overflow-hidden group relative cursor-pointer"
                data-category="<?= $image->category()->value() ?: 'locale' ?>"
                data-title="<?= $image->caption() ?>"
              >
                <?php snippet('components/responsive-image', [
                    'image' => $image,
                    'preset' => 'gallery',
                    'sizes' => '(min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw',
                    'alt' => $image->alt()->or($image->caption())->value(),
                    'class' => 'w-full transition-transform duration-300 group-hover:scale-105',
                ]) ?>
                <div class="absolute inset-0 bg-dark/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                  <span class="text-light text-sm"><?= $image->caption() ?></span>
                </div>
              </a>
            </div>
          <?php endforeach ?>
        </div>
      <?php else: ?>
        <div class="text-center py-16">
          <p class="text-light/50 text-lg"><?= t('gallery.empty') ?></p>
        </div>
      <?php endif ?>
    </div>

    <!-- GLightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.1/js/glightbox.min.js"></script>
  </section>
</main>
<?php snippet('layout/footer') ?>
