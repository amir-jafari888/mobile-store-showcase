import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11.2.10/swiper-bundle.min.mjs';

export function initHeroSlider() {
  const root = document.querySelector('[data-hero-slider]');
  if (!root) return;

  const previous = root.querySelector('[data-hero-prev]');
  const next = root.querySelector('[data-hero-next]');
  const pagination = root.querySelector('.hero-dots');
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!root.querySelectorAll('.swiper-slide').length || !pagination) return;

  new Swiper(root.querySelector('.hero-media'), {
    direction: 'horizontal',
    loop: true,
    speed: reducedMotion ? 0 : 550,
    watchOverflow: true,
    grabCursor: false,
    autoplay: reducedMotion ? false : {
      delay: 6500,
      disableOnInteraction: false,
      pauseOnMouseEnter: false,
    },
    navigation: {
      prevEl: previous,
      nextEl: next,
    },
    pagination: {
      el: pagination,
      clickable: true,
      bulletClass: 'hero-dot',
      bulletActiveClass: 'is-active',
      renderBullet(index, className) {
        return `<button type="button" class="${className}" aria-label="نمایش بنر ${index + 1}"></button>`;
      },
    },
    a11y: {
      enabled: true,
      prevSlideMessage: 'بنر قبلی',
      nextSlideMessage: 'بنر بعدی',
      paginationBulletMessage: 'نمایش بنر شماره {{index}}',
    },
  });
}
