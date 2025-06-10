import Swiper from "swiper/bundle";

document.addEventListener('DOMContentLoaded', function() {
    carouselSwiper('#gallerySwiper');
    carouselSwiper('#homeSwiper');
    carouselSwiper('#boardSwiper');
    alertDisplay();

    const webcalButton = document.getElementById('webcal');
    if (webcalButton) {
        let userId = webcalButton.getAttribute('data-user-id');
        if(userId) {
            webcalButton.addEventListener('click', function() {
                const webcalLink = `webcal://${window.location.host}/calendar/${userId}.ics`;
                copyToClipboard(webcalLink);
            });
        }
        else {
            webcalButton.addEventListener('click', function() {
                const webcalLink = `webcal://${window.location.host}/calendar.ics`;
                copyToClipboard(webcalLink);
            });
        }
    }});

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

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const webcalButton = document.getElementById('webcal');
        if (webcalButton) {
            webcalButton.innerText = 'Gekopieerd!';
            setTimeout(() => {
                webcalButton.innerText = 'Webcal';
            }, 2000);
        }
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}

function alertDisplay() {
    const alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    }
}
