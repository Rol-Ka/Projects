import Swiper from "swiper";
import { Autoplay } from "swiper/modules";

new Swiper(".hero-slider", {

    modules: [Autoplay],

    loop: true,
    centeredSlides: true,
    grabCursor: true,

    slidesPerView: 1.2,
    spaceBetween: 24,

    autoplay: {
        delay: 4000,
        disableOnInteraction: false
    },

    breakpoints: {

        768: {
            slidesPerView: 1.6,
        },

        1024: {
            slidesPerView: 1.8,
        },

        1280: {
            slidesPerView: 2.2
        }

    }

});