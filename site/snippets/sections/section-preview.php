<?php
$dishes = $page->featured_dishes()->toStructure();
$wines = $page->featured_wines()->toStructure();
$menuPage = $site->find('menu');
$winesPage = $site->find('wines');
?>
<section class="section-padding bg-dark/80">
  <div class="container-site">
    <h2 class="font-heading text-3xl text-primary text-center mb-12">
      <?= t('home.featured') ?>
    </h2>

    <!-- Featured Dishes -->
    <?php if ($dishes->count()): ?>
      <div class="mb-16">
        <h3 class="font-heading text-2xl text-light text-center mb-8"><?= t('home.featured_dishes') ?></h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <?php foreach ($dishes as $dish): ?>
            <?php $img = $dish->image()->toFile(); ?>
            <div class="text-center">
              <?php if ($img): ?>
                <img
                  src="<?= $img->thumb(['width' => 400, 'height' => 400, 'crop' => true, 'quality' => 80])->url() ?>"
                  alt="<?= Str::esc($dish->name()->value()) ?>"
                  class="rounded-lg object-cover w-full aspect-square mb-4"
                  loading="lazy"
                >
              <?php else: ?>
                <div class="rounded-lg bg-light/5 w-full aspect-square mb-4 flex items-center justify-center">
                  <span class="text-light/20 text-sm"><?= Str::esc($dish->name()->value()) ?></span>
                </div>
              <?php endif ?>
              <h4 class="font-heading text-xl text-light mb-2"><?= $dish->name()->html() ?></h4>
              <p class="text-light/70 text-sm"><?= $dish->description()->html() ?></p>
            </div>
          <?php endforeach ?>
        </div>
        <?php if ($menuPage): ?>
          <div class="text-center mt-8">
            <a href="<?= $menuPage->url() ?>" class="btn-outline"><?= t('home.discover_menu') ?></a>
          </div>
        <?php endif ?>
      </div>
    <?php endif ?>

    <!-- Featured Wines -->
    <?php if ($wines->count()): ?>
      <div>
        <h3 class="font-heading text-2xl text-light text-center mb-8"><?= t('home.featured_wines') ?></h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <?php foreach ($wines as $wine): ?>
            <?php $img = $wine->image()->toFile(); ?>
            <div class="text-center">
              <?php if ($img): ?>
                <img
                  src="<?= $img->thumb(['width' => 400, 'height' => 400, 'crop' => true, 'quality' => 80])->url() ?>"
                  alt="<?= Str::esc($wine->name()->value()) ?>"
                  class="rounded-lg object-cover w-full aspect-square mb-4"
                  loading="lazy"
                >
              <?php else: ?>
                <div class="rounded-lg bg-light/5 w-full aspect-square mb-4 flex items-center justify-center">
                  <span class="text-light/20 text-sm"><?= Str::esc($wine->name()->value()) ?></span>
                </div>
              <?php endif ?>
              <h4 class="font-heading text-xl text-light mb-2"><?= $wine->name()->html() ?></h4>
              <p class="text-light/70 text-sm"><?= $wine->description()->html() ?></p>
            </div>
          <?php endforeach ?>
        </div>
        <?php if ($winesPage): ?>
          <div class="text-center mt-8">
            <a href="<?= $winesPage->url() ?>" class="btn-outline"><?= t('home.discover_wines') ?></a>
          </div>
        <?php endif ?>
      </div>
    <?php endif ?>
  </div>
</section>
