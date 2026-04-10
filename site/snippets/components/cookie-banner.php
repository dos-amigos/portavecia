<?php
/**
 * GDPR Cookie Consent Banner
 *
 * Alpine.js component (cookieConsent) registered in cookie-consent.js.
 * Garante Privacy compliant: equal-weight Accept/Reject, granular categories, prior blocking.
 * GA4 Measurement ID from Panel field ga4MeasurementId.
 * All strings use t() for bilingual IT/EN support.
 */
?>
<div
  x-data="cookieConsent()"
  x-show="showBanner"
  x-cloak
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 translate-y-4"
  x-transition:enter-end="opacity-100 translate-y-0"
  @cookie-reopen.window="reopenBanner()"
  data-ga4-id="<?= esc($site->ga4MeasurementId()->value() ?? '', 'attr') ?>"
  class="fixed bottom-0 left-0 right-0 z-[9998] bg-dark border-t border-light/10 shadow-2xl">

  <!-- Main Banner -->
  <div x-show="!showCustomize" class="max-w-6xl mx-auto px-4 sm:px-6 py-5">
    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between">
      <p class="text-light/70 text-sm leading-relaxed max-w-2xl">
        <?= t('cookie.message') ?>
        <a href="<?= ($cp = $site->find('cookie-policy')) ? $cp->url() : '#' ?>" class="text-primary underline hover:text-primary-dark transition-colors"><?= t('cookie.policy_link') ?></a>
      </p>
      <div class="flex flex-nowrap gap-2 sm:gap-3 shrink-0 w-full md:w-auto">
        <button @click="rejectAll()"
                class="flex-1 md:flex-none px-3 sm:px-5 py-2.5 text-xs sm:text-sm font-semibold border border-light/20 text-light/80 rounded-md hover:bg-light/10 transition-colors whitespace-nowrap">
          <?= t('cookie.reject') ?>
        </button>
        <button @click="showCustomize = true"
                class="flex-1 md:flex-none px-3 sm:px-5 py-2.5 text-xs sm:text-sm font-semibold border border-light/20 text-light/80 rounded-md hover:bg-light/10 transition-colors whitespace-nowrap">
          <?= t('cookie.customize') ?>
        </button>
        <button @click="acceptAll()"
                class="flex-1 md:flex-none px-3 sm:px-5 py-2.5 text-xs sm:text-sm font-semibold bg-primary text-white rounded-md hover:bg-primary-dark transition-colors whitespace-nowrap">
          <?= t('cookie.accept') ?>
        </button>
      </div>
    </div>
  </div>

  <!-- Customize Panel -->
  <div x-show="showCustomize" x-cloak class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
    <h3 class="text-light font-heading font-bold text-lg mb-4"><?= t('cookie.customize') ?></h3>

    <div class="space-y-4 mb-6">

      <!-- Technical (always on) -->
      <div class="flex items-center justify-between bg-light/5 rounded-lg px-4 py-3">
        <div>
          <p class="text-light text-sm font-semibold"><?= t('cookie.technical') ?></p>
        </div>
        <span class="text-primary text-xs font-semibold uppercase tracking-wide"><?= t('cookie.always_active') ?></span>
      </div>

      <!-- Analytics -->
      <label class="flex items-center justify-between bg-light/5 rounded-lg px-4 py-3 cursor-pointer">
        <div>
          <p class="text-light text-sm font-semibold"><?= t('cookie.analytics') ?></p>
        </div>
        <div class="relative">
          <input type="checkbox" x-model="analyticsEnabled" class="sr-only peer">
          <div class="w-11 h-6 bg-light/20 rounded-full peer-checked:bg-primary transition-colors"></div>
          <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform"></div>
        </div>
      </label>

      <!-- Third-party -->
      <label class="flex items-center justify-between bg-light/5 rounded-lg px-4 py-3 cursor-pointer">
        <div>
          <p class="text-light text-sm font-semibold"><?= t('cookie.thirdparty') ?></p>
        </div>
        <div class="relative">
          <input type="checkbox" x-model="thirdpartyEnabled" class="sr-only peer">
          <div class="w-11 h-6 bg-light/20 rounded-full peer-checked:bg-primary transition-colors"></div>
          <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform"></div>
        </div>
      </label>

    </div>

    <div class="flex flex-wrap gap-3">
      <button @click="showCustomize = false"
              class="px-5 py-2.5 text-sm font-semibold border border-light/20 text-light/80 rounded-md hover:bg-light/10 transition-colors">
        <?= t('cookie.back') ?>
      </button>
      <button @click="savePreferences()"
              class="px-5 py-2.5 text-sm font-semibold bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
        <?= t('cookie.save') ?>
      </button>
    </div>
  </div>

</div>
