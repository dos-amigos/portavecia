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

  <?php
  // Alternating storytelling blocks per D-10
  $blocks = [
    ['title' => 'story_title', 'text' => 'story_text', 'image' => 'story_image'],
    ['title' => 'place_title', 'text' => 'place_text', 'image' => 'place_image'],
    ['title' => 'fusion_title', 'text' => 'fusion_text', 'image' => 'fusion_image'],
    ['title' => 'atmosphere_title', 'text' => 'atmosphere_text', 'image' => 'atmosphere_image'],
  ];
  foreach ($blocks as $i => $block):
    snippet('sections/about-block', [
      'page' => $page,
      'block' => $block,
      'reverse' => ($i % 2 !== 0),
    ]);
  endforeach;
  ?>
</main>
<?php snippet('layout/footer') ?>
