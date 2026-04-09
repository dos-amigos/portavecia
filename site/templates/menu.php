<?php snippet('layout/header') ?>
<main>
  <?php snippet('sections/page-hero', ['page' => $page]) ?>

  <?php
  $categories = [
    'antipasti' => t('menu.antipasti'),
    'primi' => t('menu.primi'),
    'secondi' => t('menu.secondi'),
    'zuppe' => t('menu.zuppe'),
    'dolci' => t('menu.dolci'),
  ];
  foreach ($categories as $cat => $label):
    $dishes = $page->$cat()->toStructure();
    if ($dishes->count()):
  ?>
  <section class="section-padding">
    <div class="container-site">
      <h2 class="font-heading text-3xl text-primary mb-8 reveal" style="opacity:0; transform:translateY(30px)"><?= $label ?></h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 stagger-children">
        <?php foreach ($dishes as $dish): ?>
          <?php snippet('sections/dish-card', ['dish' => $dish]) ?>
        <?php endforeach ?>
      </div>
    </div>
  </section>
  <?php
    endif;
  endforeach;
  ?>
</main>
<?php snippet('layout/footer') ?>
