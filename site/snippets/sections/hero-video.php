<?php
$video = $page->hero_video()->toFile();
$poster = $page->hero_poster()->toFile();
$waNumber = $whatsapp ? str_replace(['+', ' '], '', $whatsapp) : '';
?>
<section class="relative h-screen flex items-center justify-center overflow-hidden">
  <!-- Video background (desktop) -->
  <?php if ($video): ?>
    <video
      autoplay muted loop playsinline
      class="absolute inset-0 w-full h-full object-cover hidden md:block"
      <?php if ($poster): ?>poster="<?= $poster->url() ?>"<?php endif ?>
    >
      <source src="<?= $video->url() ?>" type="video/mp4">
    </video>
  <?php endif ?>

  <!-- Poster image fallback (mobile or no video) -->
  <?php if ($poster): ?>
    <div class="parallax-hero absolute inset-0 w-full h-[120%] -top-[10%]">
      <?php snippet('components/responsive-image', [
          'image' => $poster,
          'preset' => 'default',
          'sizes' => '100vw',
          'lazy' => false,
          'alt' => $page->hero_title()->value(),
          'class' => 'w-full h-full object-cover ' . ($video ? 'md:hidden' : ''),
      ]) ?>
    </div>
  <?php endif ?>

  <!-- Dark gradient overlay — darker for text readability -->
  <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.6) 50%, rgba(0,0,0,0.8) 100%);"></div>

  <!-- Content -->
  <div class="relative z-10 text-center px-4 max-w-3xl mx-auto">
    <p class="font-script text-3xl md:text-4xl text-primary/80 mb-2 reveal" style="opacity:0; transform:translateY(20px)"><?= t('footer.location') ?></p>
    <h1 class="font-heading text-4xl md:text-6xl lg:text-7xl text-light mb-4 reveal" style="opacity:0; transform:translateY(40px)">
      <?= t('hero.tagline') ?>
    </h1>
    <div class="section-divider reveal" style="opacity:0; transform:translateY(20px)"></div>
    <?php if ($page->hero_subtitle()->isNotEmpty()): ?>
      <p class="text-light/70 text-base md:text-lg mb-10 font-body max-w-xl mx-auto reveal" style="opacity:0; transform:translateY(20px)">
        <?= $page->hero_subtitle()->html() ?>
      </p>
    <?php endif ?>
    <?php if ($waNumber): ?>
      <a href="https://wa.me/<?= $waNumber ?>"
         class="btn-primary inline-flex items-center gap-2"
         target="_blank" rel="noopener">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.468l4.572-1.458A11.927 11.927 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818c-2.168 0-4.21-.567-5.975-1.558l-.427-.244-2.715.866.832-2.64-.272-.443A9.774 9.774 0 012.182 12c0-5.42 4.398-9.818 9.818-9.818S21.818 6.58 21.818 12 17.42 21.818 12 21.818z"/>
        </svg>
        <?= t('home.whatsapp_cta') ?>
      </a>
    <?php endif ?>
  </div>

  <!-- Scroll indicator -->
  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
    <svg class="w-6 h-6 text-light/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
    </svg>
  </div>
</section>
