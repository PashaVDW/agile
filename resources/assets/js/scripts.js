import Swiper from "swiper/bundle";

document.addEventListener('DOMContentLoaded', function() {
    carouselSwiper();
    openModal();
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

function openModal() {
    const eventDateInput = document.getElementsByName('start_date')[0];
    const openModalButton = document.getElementById('openModalButton');
    const submitButton = document.getElementById('submitButton');
    const modal = document.getElementById('dateModal');
    const today = new Date().toISOString().split('T')[0];

    function checkDate() {
        const selectedDate = eventDateInput.value;
        if (selectedDate < today) {
            openModalButton.classList.remove('hidden');
            submitButton.classList.add('hidden');
        } else {
            openModalButton.classList.add('hidden');
            submitButton.classList.remove('hidden');
        }
    }

    eventDateInput.addEventListener('change', checkDate);
    openModalButton.addEventListener('click', function () {
        modal.classList.toggle('hidden');
    });

    checkDate();
}
