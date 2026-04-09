<?php snippet('layout/header') ?>
<main>
  <section>
    <h1><?= $page->title() ?></h1>
    <?= $page->text()->kirbytext() ?>
  </section>
</main>
<?php snippet('layout/footer') ?>
