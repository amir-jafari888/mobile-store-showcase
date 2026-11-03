export function initProductSlider() {
  document.querySelectorAll('[data-product-slider]').forEach((slider) => {
    const track = slider.querySelector('[data-product-track]');
    const section = slider.closest('.featured-section');
    const previous = section?.querySelector('[data-product-prev]');
    const next = section?.querySelector('[data-product-next]');
    if (!track || !previous || !next) return;

    const updateControls = () => {
      const maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
      previous.disabled = track.scrollLeft >= -1;
      next.disabled = track.scrollLeft <= -maxScroll + 1;
      const canScroll = maxScroll > 2;
      previous.hidden = !canScroll;
      next.hidden = !canScroll;
    };

    const move = (direction) => {
      const card = track.querySelector('.product-card');
      const gap = Number.parseFloat(getComputedStyle(track).columnGap) || 16;
      const distance = card ? card.getBoundingClientRect().width + gap : track.clientWidth * 0.8;
      track.scrollBy({ left: direction * distance, behavior: 'smooth' });
    };

    previous.addEventListener('click', () => move(1));
    next.addEventListener('click', () => move(-1));
    track.addEventListener('scroll', updateControls, { passive: true });
    window.addEventListener('resize', updateControls);
    updateControls();
  });
}
