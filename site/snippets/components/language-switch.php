<nav class="flex items-center gap-1" aria-label="Language">
  <?php foreach ($kirby->languages() as $language): ?>
    <a href="<?= $page->url($language->code()) ?>"
       hreflang="<?= $language->code() ?>"
       <?php e($kirby->language() == $language, 'aria-current="true"') ?>
       class="px-2 py-1 text-sm font-body font-semibold uppercase tracking-wider transition-colors <?php e($kirby->language() == $language, 'text-primary', 'text-light/60 hover:text-light') ?>">
      <?= strtoupper($language->code()) ?>
    </a>
    <?php if (!$language->isLast()): ?>
      <span class="text-light/30">|</span>
    <?php endif ?>
  <?php endforeach ?>
</nav>
