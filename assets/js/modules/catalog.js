export function initCatalogFilters() {
  const filters = [...document.querySelectorAll('[data-filter]')];
  const cards = [...document.querySelectorAll('[data-category]')];
  if (!cards.length) return;
  const search = document.querySelector('[data-catalog-search]');
  const sort = document.querySelector('[data-catalog-sort]');
  const count = document.querySelector('[data-catalog-count]');
  const grid = document.querySelector('[data-catalog-grid]');
  const empty = document.querySelector('[data-catalog-empty]');
  const noResults = document.querySelector('[data-catalog-no-results]');
  let selected = new URLSearchParams(window.location.search).get('category') || 'all';
  if (!filters.some(button => button.dataset.filter === selected)) selected = 'all';

  const render = () => {
    const term = (search?.value || '').trim().toLocaleLowerCase('fa');
    let visible = 0;
    cards.forEach(card => {
      const matchesCategory = selected === 'all' || card.dataset.category === selected;
      const matchesSearch = !term || card.dataset.search?.toLocaleLowerCase('fa').includes(term);
      card.hidden = !(matchesCategory && matchesSearch);
      if (!card.hidden) visible++;
    });
    if (count) count.textContent = String(visible);
    if (empty) empty.hidden = cards.length !== 0;
    if (noResults) noResults.hidden = visible !== 0 || cards.length === 0;
    if (grid && sort?.value === 'name') {
      [...cards].sort((a,b) => a.dataset.name.localeCompare(b.dataset.name,'fa')).forEach(card => grid.append(card));
    } else if (grid && sort?.value === 'default') {
      [...cards].sort((a,b) => Number(a.dataset.order) - Number(b.dataset.order)).forEach(card => grid.append(card));
    }
  };

  filters.forEach(button => {
    const active = button.dataset.filter === selected;
    button.classList.toggle('is-active', active);
    button.setAttribute('aria-pressed', String(active));
    button.addEventListener('click', () => {
      selected = button.dataset.filter;
      filters.forEach(filter => {
        const isActive = filter.dataset.filter === selected;
        filter.classList.toggle('is-active', isActive);
        filter.setAttribute('aria-pressed', String(isActive));
      });
      render();
    });
  });
  search?.addEventListener('input', render);
  sort?.addEventListener('change', render);
  render();
}