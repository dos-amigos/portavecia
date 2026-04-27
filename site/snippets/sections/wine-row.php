<div class="flex flex-col md:flex-row gap-8 items-start border-b border-light/10 pb-12 md:pb-16 last:border-0">
  <!-- Bottle photo (left) -->
  <?php if ($photo = $wine->photo()->toFile()): ?>
    <div class="md:w-1/4 flex-shrink-0">
      <?php snippet('components/responsive-image', [
          'image' => $photo,
          'preset' => 'default',
          'sizes' => '(min-width: 768px) 20vw, 40vw',
          'alt' => $wine->name()->value(),
          'class' => 'w-full max-w-[200px] mx-auto md:mx-0 rounded-lg',
      ]) ?>
    </div>
  <?php endif ?>

  <!-- Wine details (right) -->
  <div class="flex-1">
    <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4">
      <div>
        <h2 class="font-heading text-2xl text-light mb-1"><?= $wine->name() ?></h2>
        <?php if ($wine->grape()->isNotEmpty()): ?>
          <p class="text-primary text-sm font-semibold uppercase tracking-wider"><?= $wine->grape() ?></p>
        <?php endif ?>
        <?php if ($wine->origin()->isNotEmpty()): ?>
          <p class="text-light/50 text-sm"><?= $wine->origin() ?></p>
        <?php endif ?>
      </div>
      <?php if ($wine->price()->isNotEmpty()): ?>
        <span class="text-primary font-heading mt-2 md:mt-0" style="font-size:0.9rem"><?= $wine->price() ?></span>
      <?php endif ?>
    </div>

    <?php if ($wine->tasting_notes()->isNotEmpty()): ?>
      <p class="text-light/70 text-sm leading-relaxed mb-4"><?= $wine->tasting_notes() ?></p>
    <?php endif ?>

    <?php if ($wine->food_pairing()->isNotEmpty()): ?>
      <p class="text-light/50 text-xs">
        <span class="text-primary/70 font-semibold uppercase tracking-wider"><?= t('wines.pairing') ?>:</span>
        <?= $wine->food_pairing() ?>
      </p>
    <?php endif ?>
  </div>
</div>
