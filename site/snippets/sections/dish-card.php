<div class="flex items-center gap-5 bg-dark/50 border border-light/10 rounded-lg p-5">
  <!-- Circular photo -->
  <div class="shrink-0 w-28 h-28 rounded-full overflow-hidden border-2 border-primary/30">
    <?php if ($photo = $dish->photo()->toFile()): ?>
      <?php snippet('components/responsive-image', [
          'image' => $photo,
          'preset' => 'card',
          'sizes' => '112px',
          'alt' => $dish->dish_name()->value(),
          'class' => 'w-full h-full object-cover',
      ]) ?>
    <?php else: ?>
      <div class="w-full h-full bg-primary/10 flex items-center justify-center">
        <span class="text-primary/40 text-2xl">&#127860;</span>
      </div>
    <?php endif ?>
  </div>
  <!-- Content -->
  <div class="flex-1 min-w-0">
    <div class="flex justify-between items-start mb-1">
      <h3 class="font-heading text-xl text-light"><?= $dish->dish_name() ?></h3>
      <?php if ($dish->price()->isNotEmpty()): ?>
        <span class="text-primary font-semibold text-lg ml-4 whitespace-nowrap">&euro; <?= $dish->price() ?></span>
      <?php endif ?>
    </div>
    <?php if ($dish->description()->isNotEmpty()): ?>
      <p class="text-light/70 text-sm"><?= $dish->description() ?></p>
    <?php endif ?>
    <?php if ($dish->wine_pairing()->isNotEmpty()): ?>
      <p class="text-primary/70 text-xs italic mt-2">
        <span class="inline-block mr-1">&#127863;</span>
        <?= $dish->wine_pairing() ?>
      </p>
    <?php endif ?>
  </div>
</div>
