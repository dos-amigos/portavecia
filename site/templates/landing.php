<?php snippet('layout/header') ?>
<main>

  <!-- Hero section -->
  <section style="position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden;min-height:50vh;background:#0a0a0e">
    <!-- Gradient overlay -->
    <div style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(200,169,126,0.08) 0%, rgba(10,10,14,0.95) 100%)"></div>
    <!-- Content -->
    <div style="position:relative;z-index:10;text-align:center;padding:6rem 1.5rem;max-width:48rem;margin:0 auto">
      <h1 class="font-heading text-light" style="font-size:2.5rem;line-height:1.1;margin-bottom:1rem;opacity:0;transform:translateY(40px)" class="reveal">
        <?= $page->headline()->or($page->title()) ?>
      </h1>
      <div style="width:60px;height:2px;background:#c8a97e;margin:1.5rem auto"></div>
    </div>
  </section>

  <!-- Main content -->
  <section style="padding:4rem 1.5rem">
    <div style="max-width:48rem;margin:0 auto">
      <div class="prose" style="color:rgba(255,255,255,0.85);font-size:1.0625rem;line-height:1.8">
        <?= $page->text()->kirbytext() ?>
      </div>
    </div>
  </section>

  <!-- FAQ section -->
  <?php $faq = $page->faq()->toStructure(); ?>
  <?php if ($faq->count()): ?>
  <section style="padding:3rem 1.5rem 4rem;background:rgba(255,255,255,0.02)">
    <div style="max-width:48rem;margin:0 auto">
      <h2 class="font-heading text-primary" style="font-size:1.75rem;text-align:center;margin-bottom:2.5rem">Domande Frequenti</h2>
      <div style="display:flex;flex-direction:column;gap:1rem">
        <?php foreach ($faq as $item): ?>
        <details style="border:1px solid rgba(255,255,255,0.1);border-radius:0.5rem;overflow:hidden">
          <summary style="padding:1rem 1.25rem;cursor:pointer;color:#c8a97e;font-weight:600;font-size:1.0625rem;background:rgba(255,255,255,0.03)">
            <?= $item->question() ?>
          </summary>
          <div style="padding:1rem 1.25rem;color:rgba(255,255,255,0.75);line-height:1.7;font-size:0.9375rem">
            <?= $item->answer()->kirbytext() ?>
          </div>
        </details>
        <?php endforeach ?>
      </div>
    </div>
  </section>
  <?php endif ?>

  <!-- Contact info -->
  <section style="padding:3rem 1.5rem">
    <div style="max-width:48rem;margin:0 auto">
      <h2 class="font-heading text-primary" style="font-size:1.75rem;text-align:center;margin-bottom:2rem">Dove Trovarci</h2>

      <div style="display:flex;flex-wrap:wrap;gap:2.5rem;justify-content:center">

        <!-- Address -->
        <?php if ($address): ?>
        <div style="flex:1;min-width:220px;text-align:center">
          <div style="margin-bottom:0.5rem">
            <svg width="24" height="24" style="color:#c8a97e;margin:0 auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <p style="color:rgba(255,255,255,0.7);font-size:0.9375rem;line-height:1.6"><?= nl2br(Str::esc($address)) ?></p>
        </div>
        <?php endif ?>

        <!-- Phone -->
        <?php if ($phone): ?>
        <div style="flex:1;min-width:220px;text-align:center">
          <div style="margin-bottom:0.5rem">
            <svg width="24" height="24" style="color:#c8a97e;margin:0 auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
          </div>
          <a href="tel:<?= Str::esc($phone) ?>" style="color:rgba(255,255,255,0.7);font-size:0.9375rem;text-decoration:none"><?= Str::esc($phone) ?></a>
        </div>
        <?php endif ?>

        <!-- Hours -->
        <?php if ($hours && $hours->count()): ?>
        <div style="flex:1;min-width:220px;text-align:center">
          <div style="margin-bottom:0.5rem">
            <svg width="24" height="24" style="color:#c8a97e;margin:0 auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <ul style="list-style:none;padding:0;margin:0">
            <?php foreach ($hours as $item): ?>
            <li style="color:rgba(255,255,255,0.7);font-size:0.875rem;display:flex;justify-content:space-between;gap:1rem;max-width:220px;margin:0 auto">
              <span><?= $item->day() ?></span>
              <span style="color:rgba(255,255,255,0.5)"><?= $item->time() ?></span>
            </li>
            <?php endforeach ?>
          </ul>
        </div>
        <?php endif ?>

      </div>
    </div>
  </section>

  <!-- CTA buttons -->
  <section style="padding:2rem 1.5rem 4rem">
    <div style="max-width:32rem;margin:0 auto;display:flex;flex-direction:column;gap:1rem;align-items:center">
      <?php if ($whatsapp): ?>
      <a href="https://wa.me/<?= str_replace(['+', ' '], '', $whatsapp) ?>?text=<?= rawurlencode('Ciao! Vorrei avere informazioni su Porta Vecia.') ?>"
         target="_blank" rel="noopener noreferrer"
         style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.875rem 2rem;background:#25D366;color:#fff;font-weight:600;border-radius:0.375rem;text-decoration:none;font-size:0.9375rem;width:100%;max-width:20rem;text-align:center">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.468l4.572-1.458A11.927 11.927 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818c-2.168 0-4.21-.567-5.975-1.558l-.427-.244-2.715.866.832-2.64-.272-.443A9.774 9.774 0 012.182 12c0-5.42 4.398-9.818 9.818-9.818S21.818 6.58 21.818 12 17.42 21.818 12 21.818z"/>
        </svg>
        Scrivici su WhatsApp
      </a>
      <?php endif ?>
      <a href="https://maps.google.com/?q=Porta+Vecia+Este+Via+Giacomo+Matteotti+44"
         target="_blank" rel="noopener noreferrer"
         style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.875rem 2rem;border:1px solid #c8a97e;color:#c8a97e;font-weight:600;border-radius:0.375rem;text-decoration:none;font-size:0.9375rem;width:100%;max-width:20rem;text-align:center">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Indicazioni Stradali
      </a>
    </div>
  </section>

</main>
<?php snippet('layout/footer') ?>
