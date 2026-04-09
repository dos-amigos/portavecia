<?php
/** @var \Kirby\Cms\File $image */
$preset = $preset ?? 'default';
$lazy   = $lazy ?? true;
$alt    = $alt ?? $image->alt()->value() ?? '';
$sizes  = $sizes ?? '100vw';
$class  = $class ?? '';
?>
<?php if ($image): ?>
<picture>
  <source
    srcset="<?= $image->srcset($preset . '-webp') ?>"
    sizes="<?= $sizes ?>"
    type="image/webp"
  >
  <img
    src="<?= $image->resize(640)->url() ?>"
    srcset="<?= $image->srcset($preset) ?>"
    sizes="<?= $sizes ?>"
    alt="<?= esc($alt) ?>"
    width="<?= $image->width() ?>"
    height="<?= $image->height() ?>"
    <?php if ($lazy): ?>loading="lazy" decoding="async"<?php endif ?>
    <?php if ($class): ?>class="<?= $class ?>"<?php endif ?>
  >
</picture>
<?php endif ?>
