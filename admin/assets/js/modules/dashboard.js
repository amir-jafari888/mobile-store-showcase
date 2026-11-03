export function initAdminDashboard() {
    const body = document.body;
    const toggle = document.querySelector('[data-admin-menu-toggle]');
    const sidebar = document.getElementById('admin-sidebar');
    const backdrop = document.querySelector('[data-admin-menu-close]');

    if (!toggle || !sidebar || !backdrop) return;

    const firstLink = sidebar.querySelector('.admin-nav a');

    const closeMenu = (restoreFocus = true) => {
        if (!body.classList.contains('admin-menu-open')) return;
        body.classList.remove('admin-menu-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'باز کردن منوی مدیریت');
        if (restoreFocus) toggle.focus();
    };

    const openMenu = () => {
        if (window.innerWidth > 900) return;
        body.classList.add('admin-menu-open');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'بستن منوی مدیریت');
        firstLink?.focus();
    };

    toggle.addEventListener('click', () => {
        body.classList.contains('admin-menu-open') ? closeMenu() : openMenu();
    });

    backdrop.addEventListener('click', () => closeMenu());
    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => closeMenu(false));
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') closeMenu();
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 900) closeMenu(false);
    });
}
