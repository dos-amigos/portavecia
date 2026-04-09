<div class="bg-dark/50 border border-light/10 rounded-lg overflow-hidden flex flex-col md:flex-row<?= $isPast ? ' opacity-60' : '' ?>">
  <?php if ($photo = $event->photo()->toFile()): ?>
    <div class="md:w-1/3 h-48 md:h-auto">
      <?php snippet('components/responsive-image', [
          'image' => $photo,
          'preset' => 'card',
          'sizes' => '(min-width: 768px) 33vw, 100vw',
          'alt' => $event->title()->value(),
          'class' => 'w-full h-full object-cover',
      ]) ?>
    </div>
  <?php endif ?>
  <div class="p-6 flex-1 flex flex-col justify-between">
    <div>
      <p class="text-primary font-bold text-sm uppercase tracking-wider mb-2">
        <?= $event->event_date()->toDate('d F Y') ?><?php if ($event->event_time()->isNotEmpty()): ?> &mdash; <?= t('event.ore') ?> <?= $event->event_time() ?><?php endif ?>
      </p>
      <h3 class="font-heading text-xl text-light mb-3"><?= $event->title() ?></h3>
      <?php if ($event->description()->isNotEmpty()): ?>
        <p class="text-light/70 text-sm"><?= $event->description() ?></p>
      <?php endif ?>
    </div>
    <?php if (!$isPast && $event->whatsapp_booking()->toBool()): ?>
      <?php
        $cleanPhone = str_replace(['+', ' '], '', $whatsapp);
        $message = str_replace(
          ['{event}', '{date}'],
          [$event->title()->value(), $event->event_date()->toDate('d/m/Y')],
          t('event.whatsapp_message')
        );
      ?>
      <a href="https://wa.me/<?= $cleanPhone ?>?text=<?= rawurlencode($message) ?>"
         class="btn-primary text-center mt-4"
         target="_blank"
         rel="noopener noreferrer">
        <?= t('event.prenota') ?>
      </a>
    <?php endif ?>
  </div>
</div>
