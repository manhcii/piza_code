const productsSlider = new Swiper("#fhm-products .swiper", {
  direction: "horizontal",
  slidesPerView: 2,
  spaceBetween: 22,
  loop: false,
  speed: 750,
  autoplay: {
    delay: 2000,
  },
  navigation: {
    nextEl: "#fhm-products .slider-button-next",
    prevEl: "#fhm-products .slider-button-prev",
  },
  breakpoints: {
    480: {
      slidesPerView: 2,
    },
    575: {
      slidesPerView: 3,
    },
    767: {
      slidesPerView: 4,
    },
  },
});

