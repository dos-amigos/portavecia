<?php snippet('layout/header') ?>
<main>
  <?php snippet('sections/page-hero', ['page' => $page]) ?>

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
