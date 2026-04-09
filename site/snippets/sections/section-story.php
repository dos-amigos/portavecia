<?php
$experienceImage = $page->experience_image()->toFile();
$experienceImage2 = $page->experience_image_2()->toFile();
?>
<section class="section-padding bg-dark">
  <div class="container-site">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
      <!-- Text -->
      <div>
        <?php if ($page->experience_title()->isNotEmpty()): ?>
          <h2 class="font-heading text-3xl text-primary mb-6">
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
          <img
            src="<?= $experienceImage->thumb(['width' => 600, 'quality' => 80])->url() ?>"
            alt="<?= Str::esc($page->experience_title()->value()) ?>"
            class="rounded-lg shadow-lg w-full"
            loading="lazy"
          >
        <?php endif ?>
        <?php if ($experienceImage2): ?>
          <img
            src="<?= $experienceImage2->thumb(['width' => 400, 'quality' => 80])->url() ?>"
            alt="<?= Str::esc($page->experience_title()->value()) ?>"
            class="rounded-lg shadow-lg w-2/3 -mt-16 ml-auto relative z-10 border-4 border-dark"
            loading="lazy"
          >
        <?php endif ?>
      </div>
    </div>
  </div>
</section>
