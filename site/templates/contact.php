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

  <!-- Contact Form -->
  <section class="section-padding border-t border-light/10">
    <div class="container-site max-w-2xl">
      <h2 class="font-heading text-3xl md:text-4xl text-primary text-center mb-12"><?= t('contact.form.title') ?></h2>

      <?php if ($success): ?>
        <div class="bg-green-900/30 border border-green-500/40 text-green-200 px-6 py-4 rounded-md text-center mb-8">
          <?= t('contact.form.success') ?>
        </div>
      <?php endif ?>

      <?php if ($alert): ?>
        <div class="bg-red-900/30 border border-red-500/40 text-red-200 px-6 py-4 rounded-md mb-8">
          <ul class="list-disc list-inside space-y-1">
            <?php foreach ($alert as $msg): ?>
              <li><?= esc($msg) ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif ?>

      <form method="POST" action="<?= $page->url() ?>"
            x-data="{ loading: false }"
            @submit="loading = true">
        <?= csrf_field() ?>

        <!-- Honeypot (hidden from humans) -->
        <div class="absolute opacity-0 pointer-events-none" aria-hidden="true" tabindex="-1">
          <input type="text" name="website" value="" autocomplete="off" tabindex="-1">
        </div>

        <div class="space-y-6">
          <!-- Name -->
          <div>
            <label for="name" class="block text-light/80 text-sm uppercase tracking-wider mb-2">
              <?= t('contact.form.name') ?> <span class="text-primary">*</span>
            </label>
            <input type="text" id="name" name="name"
                   value="<?= esc($formData['name']) ?>"
                   required
                   class="w-full bg-light/5 border border-light/15 rounded-md px-4 py-3 text-light placeholder-light/30
                          focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-light/80 text-sm uppercase tracking-wider mb-2">
              <?= t('contact.form.email') ?> <span class="text-primary">*</span>
            </label>
            <input type="email" id="email" name="email"
                   value="<?= esc($formData['email']) ?>"
                   required
                   class="w-full bg-light/5 border border-light/15 rounded-md px-4 py-3 text-light placeholder-light/30
                          focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
          </div>

          <!-- Phone (optional) -->
          <div>
            <label for="phone" class="block text-light/80 text-sm uppercase tracking-wider mb-2">
              <?= t('contact.form.phone') ?>
            </label>
            <input type="tel" id="phone" name="phone"
                   value="<?= esc($formData['phone']) ?>"
                   class="w-full bg-light/5 border border-light/15 rounded-md px-4 py-3 text-light placeholder-light/30
                          focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
          </div>

          <!-- Message -->
          <div>
            <label for="message" class="block text-light/80 text-sm uppercase tracking-wider mb-2">
              <?= t('contact.form.message') ?> <span class="text-primary">*</span>
            </label>
            <textarea id="message" name="message" rows="5" required
                      class="w-full bg-light/5 border border-light/15 rounded-md px-4 py-3 text-light placeholder-light/30
                             focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-y"
            ><?= esc($formData['message']) ?></textarea>
          </div>

          <!-- Submit -->
          <div class="text-center pt-4">
            <button type="submit"
                    class="btn-primary"
                    :class="{ 'opacity-60 pointer-events-none': loading }"
                    :disabled="loading">
              <span x-show="!loading"><?= t('contact.form.submit') ?></span>
              <span x-show="loading" x-cloak><?= t('contact.form.sending') ?></span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>
</main>
<?php snippet('layout/footer') ?>
