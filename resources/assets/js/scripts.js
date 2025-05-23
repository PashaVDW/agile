import Swiper from "swiper/bundle";

document.addEventListener('DOMContentLoaded', function() {
    carouselSwiper('#gallerySwiper');
    carouselSwiper('#homeSwiper');
    carouselSwiper('#boardSwiper');
});

function carouselSwiper(swiperId) {
    new Swiper(swiperId, {
        slidesPerView: 1,
        spaceBetween: swiperId === '#boardSwiper' ? 20: 0,
        speed: 300,
        loop: true,
        autoplay: {
            delay: 6000,
        },
        keyboard: {
            enabled: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            500: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            980: {
                slidesPerView: swiperId === '#homeSwiper' ? 2 : 3,
            }
        }

    });
}
