<?php snippet('layout/header') ?>
<main>
  <?php snippet('sections/page-hero', ['page' => $page]) ?>

  <!-- Upcoming Events -->
  <?php if ($upcoming->count() > 0): ?>
    <section class="section-padding">
      <div class="container-site">
        <h2 class="text-xl font-heading text-primary mb-8"><?= t('events.upcoming') ?></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <?php foreach ($upcoming as $event): ?>
            <?php snippet('sections/event-card', ['event' => $event, 'isPast' => false, 'whatsapp' => $whatsapp]) ?>
          <?php endforeach ?>
        </div>
      </div>
    </section>
  <?php else: ?>
    <!-- Empty state -->
    <section class="section-padding">
      <div class="container-site text-center">
        <h2 class="font-heading text-2xl text-light/50 mb-4"><?= t('events.empty.title') ?></h2>
        <p class="text-light/40 max-w-lg mx-auto"><?= t('events.empty.body') ?></p>
      </div>
    </section>
  <?php endif ?>

  <!-- Past Events -->
  <?php if ($past->count() > 0): ?>
    <section class="section-padding">
      <div class="container-site border-t border-light/10 mt-12 pt-8">
        <h2 class="text-xl font-heading text-light/50 mb-8"><?= t('events.past') ?></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <?php foreach ($past as $event): ?>
            <?php snippet('sections/event-card', ['event' => $event, 'isPast' => true, 'whatsapp' => $whatsapp]) ?>
          <?php endforeach ?>
        </div>
      </div>
    </section>
  <?php endif ?>
</main>
<?php snippet('layout/footer') ?>
