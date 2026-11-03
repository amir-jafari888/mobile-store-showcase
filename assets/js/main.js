import { initNavigation } from './modules/navigation.js';
import { initCatalogFilters } from './modules/catalog.js';
import { initCategorySlider } from './modules/category-slider.js';
import { initProductSlider } from './modules/product-slider.js';

document.addEventListener('DOMContentLoaded', () => {
  initNavigation();
  initCatalogFilters();
  initCategorySlider();
  initProductSlider();
});
