import Swiper from "swiper/bundle";

document.addEventListener('DOMContentLoaded', function() {
    carouselSwiper();
});

function carouselSwiper() {
    new Swiper('#gallerySwiper', {
        slidesPerView: 1,
        spaceBetween: 0,
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
            768: {
                slidesPerView: 2,
            },
            980: {
                slidesPerView: 3,
            }
        }
    });
}
