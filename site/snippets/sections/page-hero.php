<?php
/**
 * Page hero with background image, title, and intro
 * Usage: snippet('sections/page-hero', ['page' => $page, 'image' => 'hero-image.jpg'])
 */
$heroImage = null;
if (isset($image)) {
    $heroImage = $page->file($image);
}
// Fallback: look for any file with "hero" in the name
if (!$heroImage) {
    foreach ($page->files() as $file) {
        if (str_contains(strtolower($file->filename()), 'hero')) {
            $heroImage = $file;
            break;
        }
    }
}
?>
<section class="relative flex items-center justify-center overflow-hidden" style="min-height: 50vh;">
  <?php if ($heroImage): ?>
    <img src="<?= $heroImage->url() ?>"
         alt="<?= $page->headline()->or($page->title())->value() ?>"
         class="absolute inset-0 w-full h-full object-cover"
         loading="eager">
  <?php endif ?>

  <!-- Gradient overlay -->
  <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.6) 50%, rgba(0,0,0,0.8) 100%);"></div>

  <!-- Content -->
  <div class="relative z-10 text-center px-6 py-24 md:py-32 max-w-3xl mx-auto">
    <h1 class="font-heading text-4xl md:text-6xl lg:text-7xl text-light mb-4 reveal" style="opacity:0; transform:translateY(40px)">
      <?= $page->headline()->or($page->title()) ?>
    </h1>
    <div class="section-divider reveal" style="opacity:0; transform:translateY(20px)"></div>
    <?php if ($page->intro()->isNotEmpty()): ?>
      <p class="text-light/70 text-base md:text-lg max-w-2xl mx-auto reveal" style="opacity:0; transform:translateY(20px)">
        <?= $page->intro() ?>
      </p>
    <?php endif ?>
  </div>
</section>
