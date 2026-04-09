<?php if ($whatsapp): ?>
<style>
  .wa-float {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    z-index: 9999;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none;
  }
  .wa-float:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 25px rgba(37, 211, 102, 0.6);
  }
  .wa-float svg {
    width: 32px;
    height: 32px;
    fill: white;
  }
  .wa-float::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: rgba(37, 211, 102, 0.3);
    animation: wa-pulse 2s ease-out infinite;
  }
  @keyframes wa-pulse {
    0% { transform: scale(1); opacity: 0.6; }
    100% { transform: scale(1.6); opacity: 0; }
  }
</style>
<a href="https://wa.me/<?= str_replace(['+', ' '], '', $whatsapp) ?>"
   class="wa-float"
   target="_blank" rel="noopener"
   aria-label="WhatsApp">
  <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
    <path d="M16.004 0h-.008C7.174 0 0 7.176 0 16c0 3.5 1.128 6.744 3.046 9.378L1.054 31.29l6.118-1.958A15.9 15.9 0 0016.004 32C24.826 32 32 24.822 32 16S24.826 0 16.004 0zm9.302 22.602c-.39 1.1-1.932 2.014-3.164 2.28-.844.18-1.946.324-5.656-1.214-4.746-1.968-7.8-6.78-8.034-7.094-.226-.314-1.886-2.512-1.886-4.79 0-2.278 1.194-3.398 1.618-3.862.39-.426 1.032-.618 1.646-.618.198 0 .376.01.536.018.464.02.696.048 1.002.774.382.906 1.314 3.208 1.43 3.44.116.234.232.546.076.86-.148.322-.278.466-.512.734-.234.268-.456.472-.69.762-.214.254-.456.526-.196.99.26.464 1.156 1.904 2.484 3.084 1.706 1.518 3.144 1.99 3.59 2.21.348.172.762.138 1.034-.148.344-.366.77-.972 1.2-1.572.31-.428.698-.482 1.08-.332.386.146 2.442 1.152 2.862 1.362.42.21.7.314.804.49.102.174.102 1.012-.288 2.112z"/>
  </svg>
</a>
<?php endif ?>
