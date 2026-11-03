export function initAdminDashboard() {
    const body = document.body;
    const toggle = document.querySelector('[data-admin-menu-toggle]');
    const sidebar = document.getElementById('admin-sidebar');
    const backdrop = document.querySelector('[data-admin-menu-close]');
    if (!toggle || !sidebar || !backdrop) return;

    const closeMenu = () => {
        body.classList.remove('admin-menu-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'باز کردن منوی مدیریت');
    };
    const openMenu = () => {
        body.classList.add('admin-menu-open');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'بستن منوی مدیریت');
    };

    toggle.addEventListener('click', () => {
        body.classList.contains('admin-menu-open') ? closeMenu() : openMenu();
    });
    backdrop.addEventListener('click', closeMenu);
    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') closeMenu();
    });
    window.addEventListener('resize', () => {
        if (window.innerWidth > 900) closeMenu();
    });
}
