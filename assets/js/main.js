import { initNavigation } from './modules/navigation.js';
import { initCatalogFilters } from './modules/catalog.js';
import { initHeroSlider } from './modules/hero-slider.js';

document.addEventListener('DOMContentLoaded', () => {
  initNavigation();
  initCatalogFilters();
  initHeroSlider();
});
