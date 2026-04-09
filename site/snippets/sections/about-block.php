<?php
$title = $page->{$block['title']}();
$text = $page->{$block['text']}();
$img = $page->{$block['image']}()->toFile();
if ($title->isEmpty() && $text->isEmpty()) return;
?>
<section class="section-padding">
  <div class="container-site grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
    <div class="<?= $reverse ? 'md:order-2' : '' ?>">
      <h2 class="font-heading text-3xl text-primary mb-6"><?= $title ?></h2>
      <div class="prose prose-invert">
        <?= $text->kirbytext() ?>
      </div>
    </div>
    <div class="<?= $reverse ? 'md:order-1' : '' ?>">
      <?php if ($img): ?>
        <img src="<?= $img->thumb(['width' => 800, 'quality' => 80])->url() ?>"
             alt="<?= $img->alt()->or($title) ?>"
             class="rounded-lg w-full shadow-lg"
             loading="lazy">
      <?php endif ?>
    </div>
  </div>
</section>
