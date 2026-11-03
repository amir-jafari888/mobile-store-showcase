export function initNavigation() {
  const toggle = document.querySelector('.menu-toggle');
  const navigation = document.querySelector('#primary-nav');
  const backdrop = document.querySelector('[data-menu-backdrop]');
  if (!toggle || !navigation || !backdrop) return;

  const isMobile = () => window.matchMedia('(max-width: 1009px)').matches;
  const closeMenu = (restoreFocus = false) => {
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'باز کردن منو');
    navigation.classList.remove('is-open');
    backdrop.hidden = true;
    document.body.classList.remove('menu-is-open');
    navigation.removeAttribute('aria-modal');
    if (restoreFocus) toggle.focus();
  };
  const openMenu = () => {
    toggle.setAttribute('aria-expanded', 'true');
    toggle.setAttribute('aria-label', 'بستن منو');
    navigation.classList.add('is-open');
    backdrop.hidden = false;
    document.body.classList.add('menu-is-open');
    const firstLink = navigation.querySelector('a');
    window.setTimeout(() => firstLink?.focus(), 180);
  };

  toggle.addEventListener('click', () => {
    toggle.getAttribute('aria-expanded') === 'true' ? closeMenu() : openMenu();
  });
  backdrop.addEventListener('click', () => closeMenu(true));
  navigation.querySelectorAll('a').forEach(link => link.addEventListener('click', () => closeMenu()));
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') closeMenu(true);
    if (event.key === 'Tab' && toggle.getAttribute('aria-expanded') === 'true' && isMobile()) {
      const items = [...navigation.querySelectorAll('a')];
      if (!items.length) return;
      if (event.shiftKey && document.activeElement === items[0]) { event.preventDefault(); items.at(-1).focus(); }
      else if (!event.shiftKey && document.activeElement === items.at(-1)) { event.preventDefault(); items[0].focus(); }
    }
  });
  window.addEventListener('resize', () => { if (!isMobile()) closeMenu(); });
}