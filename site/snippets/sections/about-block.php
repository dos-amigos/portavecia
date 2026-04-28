<?php
$title = $page->{$block['title']}();
$text = $page->{$block['text']}();
$img = $page->{$block['image']}()->toFile();
if ($title->isEmpty() && $text->isEmpty()) return;
$textAnim = $reverse ? 'reveal-right' : 'reveal-left';
$imgAnim = $reverse ? 'reveal-left' : 'reveal-right';
?>
<section style="padding:2rem 0">
  <div class="container-site grid grid-cols-1 md:grid-cols-2 gap-16 items-center" style="gap:2rem">
    <div class="<?= $reverse ? 'md:order-2' : '' ?> <?= $textAnim ?>" style="opacity:0">
      <p class="label-text mb-3"><?= $block['title'] === 'fusion_title' ? 'Due Tradizioni' : '' ?></p>
      <h2 class="font-heading text-3xl md:text-4xl text-primary mb-6"><?= $title ?></h2>
      <div class="text-light/70 leading-relaxed">
        <?= $text->kirbytext() ?>
      </div>
    </div>
    <div class="<?= $reverse ? 'md:order-1' : '' ?> <?= $imgAnim ?> overflow-hidden" style="opacity:0">
      <?php if ($img): ?>
        <?php snippet('components/responsive-image', [
            'image' => $img,
            'preset' => 'default',
            'sizes' => '(min-width: 768px) 50vw, 100vw',
            'alt' => $img->alt()->or($title)->value(),
            'class' => 'w-full parallax',
        ]) ?>
      <?php endif ?>
    </div>
  </div>
</section>
