<div class="bg-dark/50 border border-light/10 rounded-lg overflow-hidden flex flex-col md:flex-row">
  <?php if ($photo = $dish->photo()->toFile()): ?>
    <div class="md:w-1/3 h-48 md:h-auto">
      <?php snippet('components/responsive-image', [
          'image' => $photo,
          'preset' => 'card',
          'sizes' => '(min-width: 768px) 25vw, 50vw',
          'alt' => $dish->dish_name()->value(),
          'class' => 'w-full h-full object-cover',
      ]) ?>
    </div>
  <?php endif ?>
  <div class="p-6 flex-1 flex flex-col justify-between">
    <div>
      <div class="flex justify-between items-start mb-2">
        <h3 class="font-heading text-xl text-light"><?= $dish->dish_name() ?></h3>
        <?php if ($dish->price()->isNotEmpty()): ?>
          <span class="text-primary font-semibold text-lg ml-4 whitespace-nowrap">&euro; <?= $dish->price() ?></span>
        <?php endif ?>
      </div>
      <?php if ($dish->description()->isNotEmpty()): ?>
        <p class="text-light/70 text-sm mb-3"><?= $dish->description() ?></p>
      <?php endif ?>
    </div>
    <?php if ($dish->wine_pairing()->isNotEmpty()): ?>
      <p class="text-primary/70 text-xs italic mt-2">
        <span class="inline-block mr-1">&#127863;</span>
        <?= $dish->wine_pairing() ?>
      </p>
    <?php endif ?>
  </div>
</div>
