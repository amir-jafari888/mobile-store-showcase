export function initHeroSlider() {
  const root = document.querySelector('[data-hero-slider]');
  if (!root) return;
  const slides = [...root.querySelectorAll('[data-hero-slide]')];
  const dots = [...root.querySelectorAll('[data-hero-dot]')];
  const previous = root.querySelector('[data-hero-prev]');
  const next = root.querySelector('[data-hero-next]');
  if (slides.length < 2) return;

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let activeIndex = 0;
  let intervalId = null;
  let paused = reducedMotion;

  const show = (index) => {
    activeIndex = (index + slides.length) % slides.length;
    slides.forEach((slide, i) => {
      const active = i === activeIndex;
      slide.classList.toggle('is-active', active);
      slide.setAttribute('aria-hidden', String(!active));
    });
    dots.forEach((dot, i) => {
      const active = i === activeIndex;
      dot.classList.toggle('is-active', active);
      dot.setAttribute('aria-pressed', String(active));
    });
  };
  const stop = () => {
    if (intervalId !== null) window.clearInterval(intervalId);
    intervalId = null;
  };
  const start = () => {
    stop();
    if (paused || document.hidden) return;
    intervalId = window.setInterval(() => show(activeIndex + 1), 6500);
  };

  previous?.addEventListener('click', () => { show(activeIndex - 1); start(); });
  next?.addEventListener('click', () => { show(activeIndex + 1); start(); });
  dots.forEach(dot => dot.addEventListener('click', () => { show(Number(dot.dataset.heroDot)); start(); }));
  root.addEventListener('pointerenter', () => { paused = true; stop(); });
  root.addEventListener('pointerleave', () => { paused = false; start(); });
  root.addEventListener('focusin', () => { paused = true; stop(); });
  root.addEventListener('focusout', event => {
    if (!root.contains(event.relatedTarget)) { paused = reducedMotion; start(); }
  });
  document.addEventListener('visibilitychange', start);
  start();
}
