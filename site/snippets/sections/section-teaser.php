<?php
$teaserImage = $page->teaser_image()->toFile();
?>
<section class="section-padding">
  <div class="container-site">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
      <!-- Image -->
      <div class="reveal-left overflow-hidden" style="opacity:0; transform:translateX(-60px)">
        <?php if ($teaserImage): ?>
          <?php snippet('components/responsive-image', [
              'image' => $teaserImage,
              'preset' => 'default',
              'sizes' => '(min-width: 768px) 50vw, 100vw',
              'alt' => $page->teaser_title()->value(),
              'class' => 'rounded-lg w-full',
          ]) ?>
        <?php endif ?>
      </div>
      <!-- Text -->
      <div class="reveal-right" style="opacity:0; transform:translateX(60px)">
        <?php if ($page->teaser_title()->isNotEmpty()): ?>
          <p class="label-text mb-3"><?= t('nav.about') ?></p>
          <h2 class="font-heading text-3xl md:text-4xl text-primary mb-6">
            <?= $page->teaser_title()->html() ?>
          </h2>
        <?php endif ?>
        <?php if ($page->teaser_text()->isNotEmpty()): ?>
          <div class="prose prose-invert">
            <?= $page->teaser_text()->kirbytext() ?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>
