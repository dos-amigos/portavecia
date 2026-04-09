<?php snippet('layout/header') ?>
<main class="min-h-screen">
  <div class="max-w-4xl mx-auto px-4 py-16">
    <h1 class="font-heading text-4xl text-primary mb-8"><?= $page->title() ?></h1>
    <div class="prose prose-invert">
      <?= $page->text()->kirbytext() ?>
    </div>
  </div>
</main>
<?php snippet('layout/footer') ?>
