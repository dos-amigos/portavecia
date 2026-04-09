<?php snippet('layout/header') ?>
<main>
  <h1><?= $page->title() ?></h1>
  <?= $page->text()->kirbytext() ?>
</main>
<?php snippet('layout/footer') ?>
