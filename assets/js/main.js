import { initNavigation } from './modules/navigation.js';
import { initCatalogFilters } from './modules/catalog.js';
import { initProductSwiper } from './modules/product-swiper.js';

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initCatalogFilters();
    initProductSwiper();
});