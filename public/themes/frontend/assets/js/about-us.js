const teamSlider = new Swiper("#fhm-about-team .swiper", {
  direction: "horizontal",
  slidesPerView: 1,
  spaceBetween: 45,
  loop: false,
  speed: 1000,
  autoplay: {
    delay: 2000,
  },
  navigation: {
    nextEl: "#fhm-about-team .slider-button-next",
    prevEl: "#fhm-about-team .slider-button-prev",
  },
  breakpoints: {
    767: {
      slidesPerView: 2,
    },
    1199: {
      slidesPerView: 3,
    },
  },
});

const memorableYearSlider = new Swiper(
  "#fhm-about-memorable .memorable-years .swiper",
  {
    direction: "horizontal",
    slidesPerView: 1,
    loop: false,
    speed: 1000,
    breakpoints: {
      575: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
      1199: {
        slidesPerView: 4,
      },
    },
  }
);

const memorableSlider = new Swiper(
  "#fhm-about-memorable .memorable-slider .swiper",
  {
    direction: "horizontal",
    slidesPerView: 1,
    loop: false,
    speed: 1000,
    navigation: {
      nextEl: "#fhm-about-memorable .slider-button-next",
      prevEl: "#fhm-about-memorable .slider-button-prev",
    },
    thumbs: {
      swiper: memorableYearSlider,
    },
  }
);

const valuesSlider = new Swiper("#fhm-about-values .swiper", {
  direction: "horizontal",
  slidesPerView: 1,
  speed: 1000,
  loop: true,
  navigation: {
    nextEl: "#fhm-about-values .slider-button-next",
    prevEl: "#fhm-about-values .slider-button-prev",
  },
  breakpoints: {
    767: {
      slidesPerView: 2,
    },
  },
});
