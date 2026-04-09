<?php snippet('layout/header') ?>
<main>
  <!-- Page header -->
  <section class="section-padding">
    <div class="container-site text-center">
      <h1 class="font-heading text-4xl md:text-6xl text-primary mb-4 reveal" style="opacity:0; transform:translateY(40px)"><?= $page->headline() ?></h1>
      <?php if ($page->intro()->isNotEmpty()): ?>
        <div class="section-divider reveal" style="opacity:0"></div>
        <p class="text-light/70 text-lg max-w-2xl mx-auto reveal" style="opacity:0; transform:translateY(20px)"><?= $page->intro() ?></p>
      <?php endif ?>
    </div>
  </section>

  <!-- Wine list -->
  <section class="section-padding">
    <div class="container-site">
      <div class="space-y-12 md:space-y-16 stagger-children">
        <?php foreach ($page->wines()->toStructure() as $wine): ?>
          <?php snippet('sections/wine-row', ['wine' => $wine]) ?>
        <?php endforeach ?>
      </div>
    </div>
  </section>
</main>
<?php snippet('layout/footer') ?>
