export function initProductSwiper() {
    const slider = document.querySelector('[data-product-swiper]');

    if (!slider || typeof window.Swiper !== 'function') {
        return;
    }

    new window.Swiper(slider, {
        slidesPerView: 1,
        spaceBetween: 14,
        speed: 550,
        grabCursor: true,
        watchOverflow: true,
        keyboard: {
            enabled: true,
        },
        navigation: {
            nextEl: slider.querySelector('.swiper-button-next'),
            prevEl: slider.querySelector('.swiper-button-prev'),
        },
        pagination: {
            el: slider.querySelector('.swiper-pagination'),
            clickable: true,
        },
        breakpoints: {
            601: {
                slidesPerView: 2,
                spaceBetween: 16,
            },
            1010: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
    });
}
