export function initAdminDashboard() {
    const body = document.body;
    const toggle = document.querySelector('[data-admin-menu-toggle]');
    const sidebar = document.getElementById('admin-sidebar');
    const backdrop = document.querySelector('[data-admin-menu-close]');

    if (!toggle || !sidebar || !backdrop) return;

    const firstLink = sidebar.querySelector('.admin-nav a');
    const isCompactLayout = () => window.matchMedia('(max-width: 900px)').matches;

    const closeMenu = (restoreFocus = true) => {
        if (!body.classList.contains('admin-menu-open')) return;
        body.classList.remove('admin-menu-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'باز کردن منوی مدیریت');
        if (restoreFocus && isCompactLayout()) toggle.focus();
    };

    const openMenu = () => {
        if (!isCompactLayout()) return;
        body.classList.add('admin-menu-open');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'بستن منوی مدیریت');
        firstLink?.focus();
    };

    toggle.addEventListener('click', () => {
        if (body.classList.contains('admin-menu-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    backdrop.addEventListener('click', () => closeMenu());
    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => closeMenu(false));
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') closeMenu();
    });

    window.addEventListener('resize', () => {
        if (!isCompactLayout()) closeMenu(false);
    });
}
