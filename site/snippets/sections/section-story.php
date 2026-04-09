<?php
$experienceImage = $page->experience_image()->toFile();
$experienceImage2 = $page->experience_image_2()->toFile();
?>
<section class="section-padding">
  <div class="container-site">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
      <!-- Text -->
      <div class="reveal-left" style="opacity:0; transform:translateX(-60px)">
        <?php if ($page->experience_title()->isNotEmpty()): ?>
          <p class="label-text mb-3">L'Esperienza</p>
          <h2 class="font-heading text-3xl md:text-4xl text-primary mb-6">
            <?= $page->experience_title()->html() ?>
          </h2>
        <?php endif ?>
        <?php if ($page->experience_text()->isNotEmpty()): ?>
          <div class="prose prose-invert">
            <?= $page->experience_text()->kirbytext() ?>
          </div>
        <?php endif ?>
      </div>
      <!-- Images -->
      <div class="relative">
        <?php if ($experienceImage): ?>
          <?php snippet('components/responsive-image', [
              'image' => $experienceImage,
              'preset' => 'default',
              'sizes' => '(min-width: 768px) 50vw, 100vw',
              'alt' => $page->experience_title()->value(),
              'class' => 'rounded-lg shadow-lg w-full',
          ]) ?>
        <?php endif ?>
        <?php if ($experienceImage2): ?>
          <?php snippet('components/responsive-image', [
              'image' => $experienceImage2,
              'preset' => 'default',
              'sizes' => '(min-width: 768px) 33vw, 100vw',
              'alt' => $page->experience_title()->value(),
              'class' => 'rounded-lg shadow-lg w-2/3 -mt-16 ml-auto relative z-10 border-4 border-dark',
          ]) ?>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>
