<?php
$teaserImage = $page->teaser_image()->toFile();
?>
<section class="section-padding bg-dark">
  <div class="container-site">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
      <!-- Image -->
      <div>
        <?php if ($teaserImage): ?>
          <img
            src="<?= $teaserImage->thumb(['width' => 800, 'quality' => 80])->url() ?>"
            alt="<?= Str::esc($page->teaser_title()->value()) ?>"
            class="rounded-lg w-full"
            loading="lazy"
          >
        <?php endif ?>
      </div>
      <!-- Text -->
      <div>
        <?php if ($page->teaser_title()->isNotEmpty()): ?>
          <h2 class="font-heading text-3xl text-primary mb-6">
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
