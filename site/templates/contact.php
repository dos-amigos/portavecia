<?php snippet('layout/header') ?>
<main>
  <?php snippet('sections/page-hero', ['page' => $page]) ?>

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
               class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded-md transition-colors text-sm uppercase tracking-wider wa-bg"
               target="_blank" rel="noopener noreferrer">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.468l4.572-1.458A11.927 11.927 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818c-2.168 0-4.21-.567-5.975-1.558l-.427-.244-2.715.866.832-2.64-.272-.443A9.774 9.774 0 012.182 12c0-5.42 4.398-9.818 9.818-9.818S21.818 6.58 21.818 12 17.42 21.818 12 21.818z"/>
              </svg>
              <?= t('cta.whatsapp') ?>
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
