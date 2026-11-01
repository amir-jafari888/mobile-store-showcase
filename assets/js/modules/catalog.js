export function initCatalogFilters() {
    const filters = [...document.querySelectorAll('[data-filter]')];
    const cards = [...document.querySelectorAll('[data-category]')];
    if (!filters.length || !cards.length) return;

    const applyFilter = selected => {
        cards.forEach(card => {
            card.hidden = selected !== 'all' && card.dataset.category !== selected;
        });
    };

    const initial = filters.find(button => button.classList.contains('is-active'))?.dataset.filter || 'all';
    filters.forEach(button => {
        const active = button.dataset.filter === initial;
        button.classList.toggle('is-active', active);
        button.setAttribute('aria-pressed', String(active));
        button.addEventListener('click', () => {
            filters.forEach(filter => {
                const selected = filter === button;
                filter.classList.toggle('is-active', selected);
                filter.setAttribute('aria-pressed', String(selected));
            });
            applyFilter(button.dataset.filter);
        });
    });
    applyFilter(initial);
}
