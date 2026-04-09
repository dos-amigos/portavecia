<?php snippet('layout/header') ?>
<main>
  <!-- Page header -->
  <section class="section-padding bg-dark">
    <div class="container-site text-center">
      <h1 class="font-heading text-4xl md:text-5xl text-primary mb-4"><?= $page->headline() ?></h1>
      <?php if ($page->intro()->isNotEmpty()): ?>
        <p class="text-light/70 text-lg max-w-2xl mx-auto"><?= $page->intro() ?></p>
      <?php endif ?>
    </div>
  </section>

  <!-- Split layout: map left, info right -->
  <section class="section-padding">
    <div class="container-site grid grid-cols-1 md:grid-cols-2 gap-12">
      <!-- Map (left) per D-08 -->
      <div>
        <?php snippet('sections/contact-map', [
          'lat' => $page->map_lat()->or('45.2272')->value(),
          'lng' => $page->map_lng()->or('11.6574')->value(),
          'popup' => $page->map_popup()->or('Porta Vecia')->value(),
        ]) ?>
      </div>

      <!-- Contact info (right) -->
      <div class="space-y-8">
        <!-- Address per CONT-04 -->
        <?php if ($address): ?>
          <div>
            <h2 class="font-heading text-2xl text-primary mb-3"><?= t('contact.address') ?></h2>
            <p class="text-light/70"><?= nl2br(Str::esc($address)) ?></p>
            <?php if ($page->directions_url()->isNotEmpty()): ?>
              <a href="<?= $page->directions_url() ?>" target="_blank" rel="noopener"
                 class="btn-outline inline-block mt-4 text-xs">
                <?= t('contact.directions') ?>
              </a>
            <?php endif ?>
          </div>
        <?php endif ?>

        <!-- Opening hours per CONT-02 -->
        <div>
          <h2 class="font-heading text-2xl text-primary mb-3"><?= t('footer.hours') ?></h2>
          <?php if ($hours && $hours->count()): ?>
            <ul class="space-y-2">
              <?php foreach ($hours as $item): ?>
                <li class="text-light/70 flex justify-between">
                  <span><?= $item->day() ?></span>
                  <span class="font-semibold"><?= $item->time() ?></span>
                </li>
              <?php endforeach ?>
            </ul>
          <?php endif ?>
        </div>

        <!-- Phone and WhatsApp per CONT-03 -->
        <div class="flex flex-col gap-3">
          <?php if ($phone): ?>
            <a href="tel:<?= Str::esc($phone) ?>"
               class="btn-primary text-center">
              <?= t('contact.call') ?> <?= Str::esc($phone) ?>
            </a>
          <?php endif ?>
          <?php if ($whatsapp): ?>
            <a href="https://wa.me/<?= str_replace(['+', ' '], '', $whatsapp) ?>"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#25D366] text-white font-semibold rounded-md hover:bg-[#20bd5a] transition-colors text-sm uppercase tracking-wider"
               target="_blank" rel="noopener">
              WhatsApp
            </a>
          <?php endif ?>
        </div>

        <!-- Email -->
        <?php if ($email): ?>
          <div>
            <a href="mailto:<?= Str::esc($email) ?>" class="text-primary hover:text-primary-dark transition-colors">
              <?= Str::esc($email) ?>
            </a>
          </div>
        <?php endif ?>
      </div>
    </div>
  </section>
</main>
<?php snippet('layout/footer') ?>
