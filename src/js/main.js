import Alpine from 'alpinejs'
import '../css/main.css'
import './cookie-consent.js'

window.Alpine = Alpine
Alpine.start()

// Gallery filter + GLightbox integration
window.galleryFilter = function() {
  return {
    activeFilter: 'all',
    lightbox: null,

    init() {
      this.$nextTick(() => this.buildLightbox());
    },

    setFilter(filter) {
      this.activeFilter = filter;
      this.$nextTick(() => {
        setTimeout(() => this.buildLightbox(), 250);
      });
    },

    buildLightbox() {
      if (this.lightbox) {
        this.lightbox.destroy();
      }

      const container = this.$el.querySelector('.gallery-grid');
      if (!container) return;

      const visibleItems = container.querySelectorAll('.glightbox');
      const elements = [];
      const clickTargets = [];

      visibleItems.forEach(el => {
        if (el.offsetParent !== null) {
          elements.push({
            href: el.getAttribute('href'),
            type: 'image',
            title: el.getAttribute('data-title') || '',
          });
          clickTargets.push(el);
        }
      });

      if (elements.length === 0) return;

      this.lightbox = GLightbox({ elements, loop: true, zoomable: true, touchNavigation: true });

      clickTargets.forEach((el, i) => {
        el.onclick = (e) => {
          e.preventDefault();
          this.lightbox.openAt(i);
        };
      });
    }
  };
};
