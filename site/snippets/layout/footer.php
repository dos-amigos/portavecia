<footer class="bg-dark border-t border-light/10 mt-16">
  <div class="max-w-6xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

      <!-- Column 1: Contact info -->
      <div>
        <h3 class="text-primary font-heading text-lg mb-4">Porta Vecia</h3>
        <?php if ($address): ?>
          <p class="text-light/70 text-sm mb-3"><?= nl2br(Str::esc($address)) ?></p>
        <?php endif ?>
        <?php if ($phone): ?>
          <p class="text-light/70 text-sm mb-2">
            <a href="tel:<?= Str::esc($phone) ?>" class="hover:text-primary transition-colors"><?= Str::esc($phone) ?></a>
          </p>
        <?php endif ?>
        <?php if ($whatsapp): ?>
          <p class="text-light/70 text-sm mb-2">
            <a href="https://wa.me/<?= str_replace(['+', ' '], '', $whatsapp) ?>" class="hover:text-primary transition-colors" target="_blank" rel="noopener">WhatsApp</a>
          </p>
        <?php endif ?>
        <?php if ($email): ?>
          <p class="text-light/70 text-sm">
            <a href="mailto:<?= Str::esc($email) ?>" class="hover:text-primary transition-colors"><?= Str::esc($email) ?></a>
          </p>
        <?php endif ?>
      </div>

      <!-- Column 2: Opening hours -->
      <div>
        <h3 class="text-primary font-heading text-lg mb-4"><?= t('footer.hours') ?></h3>
        <?php if ($hours && $hours->count()): ?>
          <ul class="space-y-2">
            <?php foreach ($hours as $item): ?>
              <li class="text-light/70 text-sm flex justify-between">
                <span><?= $item->day() ?></span>
                <span><?= $item->time() ?></span>
              </li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
      </div>

      <!-- Column 3: Social -->
      <div>
        <h3 class="text-primary font-heading text-lg mb-4"><?= t('footer.follow') ?></h3>
        <?php if ($social && $social->count()): ?>
          <ul class="space-y-2">
            <?php foreach ($social as $item): ?>
              <li>
                <a href="<?= $item->url() ?>" class="text-light/70 text-sm hover:text-primary transition-colors" target="_blank" rel="noopener">
                  <?= $item->platform() ?>
                </a>
              </li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
      </div>

    </div>

    <!-- Copyright -->
    <div class="mt-12 pt-8 border-t border-light/10 text-center space-y-2">
      <p class="text-light/50 text-sm">&copy; <?= date('Y') ?> Porta Vecia</p>
      <button @click="$dispatch('cookie-reopen')" class="text-light/50 hover:text-primary text-xs underline transition-colors">
        <?= t('cookie.policy_link') ?>
      </button>
    </div>
  </div>
</footer>

  <?php snippet('components/whatsapp-float') ?>
  <?php snippet('components/cookie-banner') ?>
  <?= vite()->js('src/js/main.js') ?>
</body>
</html>
