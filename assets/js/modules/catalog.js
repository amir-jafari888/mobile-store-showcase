export function initCatalogFilters() {
    const filters = document.querySelectorAll('[data-filter]');
    const cards = document.querySelectorAll('[data-category]');
    if (!filters.length || !cards.length) return;

    filters.forEach(button => {
        button.setAttribute('aria-pressed', String(button.classList.contains('is-active')));
        button.addEventListener('click', () => {
            const selected = button.dataset.filter;
            filters.forEach(filter => {
                const active = filter === button;
                filter.classList.toggle('is-active', active);
                filter.setAttribute('aria-pressed', String(active));
            });
            cards.forEach(card => {
                card.hidden = selected !== 'all' && card.dataset.category !== selected;
            });
        });
    });
}