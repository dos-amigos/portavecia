import Alpine from 'alpinejs'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import Lenis from 'lenis'
import '../css/main.css'
import './cookie-consent.js'

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger)

// ─── Lenis Smooth Scroll ────────────────────────────────────

const lenis = new Lenis({
  duration: 1.2,
  easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
  smoothWheel: true,
  touchMultiplier: 2,
})

// Connect Lenis to GSAP ScrollTrigger
lenis.on('scroll', ScrollTrigger.update)

gsap.ticker.add((time) => {
  lenis.raf(time * 1000)
})
gsap.ticker.lagSmoothing(0)

// Alpine.js
window.Alpine = Alpine
Alpine.start()

// ─── GSAP Scroll Animations ─────────────────────────────────

// Wait for DOM
document.addEventListener('DOMContentLoaded', () => {

  // Reveal from bottom
  gsap.utils.toArray('.reveal').forEach(el => {
    gsap.to(el, {
      opacity: 1,
      y: 0,
      duration: 1,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 85%',
        once: true,
      }
    })
  })

  // Reveal from left
  gsap.utils.toArray('.reveal-left').forEach(el => {
    gsap.to(el, {
      opacity: 1,
      x: 0,
      duration: 1,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 85%',
        once: true,
      }
    })
  })

  // Reveal from right
  gsap.utils.toArray('.reveal-right').forEach(el => {
    gsap.to(el, {
      opacity: 1,
      x: 0,
      duration: 1,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 85%',
        once: true,
      }
    })
  })

  // Scale reveal
  gsap.utils.toArray('.reveal-scale').forEach(el => {
    gsap.to(el, {
      opacity: 1,
      scale: 1,
      duration: 0.8,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 85%',
        once: true,
      }
    })
  })

  // Staggered children
  gsap.utils.toArray('.stagger-children').forEach(container => {
    const children = container.children
    gsap.to(children, {
      opacity: 1,
      y: 0,
      duration: 0.6,
      stagger: 0.1,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: container,
        start: 'top 85%',
        once: true,
      }
    })
  })

  // Parallax effect on images with .parallax class
  gsap.utils.toArray('.parallax').forEach(el => {
    gsap.to(el, {
      yPercent: -15,
      ease: 'none',
      scrollTrigger: {
        trigger: el.parentElement,
        start: 'top bottom',
        end: 'bottom top',
        scrub: true,
      }
    })
  })

  // Page entrance animation
  gsap.from('main', {
    opacity: 0,
    y: 20,
    duration: 0.6,
    ease: 'power2.out',
    delay: 0.1,
  })

  // Header hide/show on scroll
  const header = document.querySelector('header')
  if (header) {
    let lastScroll = 0
    ScrollTrigger.create({
      start: 'top -80',
      onUpdate: (self) => {
        const currentScroll = self.scroll()
        if (currentScroll > lastScroll && currentScroll > 200) {
          header.style.transform = 'translateY(-100%)'
          header.style.transition = 'transform 0.3s ease'
        } else {
          header.style.transform = 'translateY(0)'
          header.style.transition = 'transform 0.3s ease'
        }
        lastScroll = currentScroll
      }
    })
  }
})

// ─── Gallery Filter + GLightbox ─────────────────────────────

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
