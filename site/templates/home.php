<?php snippet('layout/header') ?>
<main>
  <?php snippet('sections/hero-video', ['page' => $page, 'whatsapp' => $whatsapp]) ?>
  <?php snippet('sections/section-teaser', ['page' => $page]) ?>
  <?php snippet('sections/section-preview', ['page' => $page, 'site' => $site]) ?>
  <?php snippet('sections/section-story', ['page' => $page]) ?>
</main>
<?php snippet('layout/footer') ?>
