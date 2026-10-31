import { initNavigation } from './modules/navigation.js';
import { initCatalogFilters } from './modules/catalog.js';

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initCatalogFilters();
});