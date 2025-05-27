import Swiper from "swiper/bundle";

document.addEventListener('DOMContentLoaded', function() {
    carouselSwiper('#gallerySwiper');
    carouselSwiper('#homeSwiper');
    carouselSwiper('#boardSwiper');
    navbar()
    const webcalButton = document.getElementById('webcal');
    if (webcalButton) {
        webcalButton.addEventListener('click', function() {
            const webcalLink = `webcal://${window.location.host}/calendar.ics`;
            copyToClipboard(webcalLink);
        });
    }
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

function navbar()
{
        const parentItems = document.querySelectorAll(".nav-item.has-children");

        parentItems.forEach(item => {
            item.addEventListener("keydown", function (event) {
                if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    const submenu = item.querySelector(".submenu");
                    submenu.style.display = submenu.style.display === "block" ? "none" : "block";
                }
            });
        });
}
