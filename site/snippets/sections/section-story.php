<?php
$experienceImage = $page->experience_image()->toFile();
$experienceImage2 = $page->experience_image_2()->toFile();
?>
<section class="pt-32 md:pt-44 pb-16 md:pb-20 px-6 md:px-8">
  <div class="container-site">
    <div class="flex flex-col md:flex-row gap-16 items-center">
      <!-- Text (left) -->
      <div class="md:w-[40%] shrink-0 reveal-left" style="opacity:0; transform:translateX(-60px)">
        <?php if ($page->experience_title()->isNotEmpty()): ?>
          <p class="label-text mb-3"><?= t('home.experience_label') ?></p>
          <h2 class="font-heading text-4xl md:text-5xl text-primary mb-6">
            <?= $page->experience_title()->html() ?>
          </h2>
        <?php endif ?>
        <?php if ($page->experience_text()->isNotEmpty()): ?>
          <div class="prose prose-invert">
            <?= $page->experience_text()->kirbytext() ?>
          </div>
        <?php endif ?>
      </div>

      <!-- Photos (right) -->
      <div class="md:w-[60%] relative">
        <?php if ($experienceImage): ?>
          <div class="parallax-photo-1 rounded-lg shadow-lg overflow-hidden" style="height:450px">
            <?php snippet('components/responsive-image', [
                'image' => $experienceImage,
                'preset' => 'default',
                'sizes' => '(min-width: 768px) 60vw, 100vw',
                'alt' => $page->experience_title()->value(),
                'class' => 'w-full h-full object-cover',
            ]) ?>
          </div>
        <?php endif ?>
        <?php if ($experienceImage2): ?>
          <div class="parallax-photo-2 rounded-lg overflow-hidden" style="width:45%; height:350px; margin-top:20px; margin-left:5%; position:relative; z-index:10; box-shadow: 0 25px 50px rgba(0,0,0,0.6), 0 10px 20px rgba(0,0,0,0.4)">
            <?php snippet('components/responsive-image', [
                'image' => $experienceImage2,
                'preset' => 'default',
                'sizes' => '(min-width: 768px) 25vw, 45vw',
                'alt' => $page->experience_title()->value(),
                'class' => 'w-full h-full object-cover',
            ]) ?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>
