<?php snippet('layout/header') ?>
<main>
  <!-- Page header -->
  <section class="section-padding bg-dark">
    <div class="container-site text-center">
      <h1 class="font-heading text-4xl md:text-5xl text-primary mb-4"><?= $page->headline() ?></h1>
      <?php if ($page->intro()->isNotEmpty()): ?>
        <p class="text-light/70 text-lg max-w-2xl mx-auto"><?= $page->intro() ?></p>
      <?php endif ?>
    </div>
  </section>

  <!-- Wine list -->
  <section class="section-padding">
    <div class="container-site">
      <div class="space-y-12 md:space-y-16">
        <?php foreach ($page->wines()->toStructure() as $wine): ?>
          <?php snippet('sections/wine-row', ['wine' => $wine]) ?>
        <?php endforeach ?>
      </div>
    </div>
  </section>
</main>
<?php snippet('layout/footer') ?>
