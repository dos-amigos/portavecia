<?php snippet('layout/header') ?>
<main>
  <?php snippet('sections/page-hero', ['page' => $page]) ?>

  <!-- Wine list -->
  <section class="section-padding">
    <div class="container-site">
      <div class="space-y-12 md:space-y-16 stagger-children">
        <?php foreach ($page->wines()->toStructure() as $wine): ?>
          <?php snippet('sections/wine-row', ['wine' => $wine]) ?>
        <?php endforeach ?>
      </div>

      <!-- CTA: more wines -->
      <div style="text-align:center;margin-top:4rem;padding-top:3rem;border-top:1px solid rgba(255,255,255,0.1)">
        <p class="font-heading text-primary" style="font-size:1.5rem;margin-bottom:0.75rem">...e tanti altri ancora</p>
        <p style="color:rgba(255,255,255,0.6);font-size:0.95rem;max-width:32rem;margin:0 auto 1.5rem">
          La nostra cantina conta oltre 100 etichette tra bollicine, bianchi, rossi e champagne. Vieni a scoprirli tutti dal vivo.
        </p>
        <?php if ($site->whatsapp()->isNotEmpty()): ?>
          <a href="https://wa.me/<?= str_replace(['+', ' '], '', $site->whatsapp()->value()) ?>"
             class="btn-primary" target="_blank" rel="noopener noreferrer">
            <?= t('cta.whatsapp') ?>
          </a>
        <?php endif ?>
      </div>
    </div>
  </section>
</main>
<?php snippet('layout/footer') ?>
