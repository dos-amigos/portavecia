<?php snippet('layout/header') ?>
<main>
  <?php snippet('sections/page-hero', ['page' => $page]) ?>

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
