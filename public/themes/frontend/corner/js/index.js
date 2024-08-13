const sliderSwiper = new Swiper(".slider-swiper", {
  direction: "horizontal",
  loop: true,
  speed: 1000,
  pagination: {
    el: ".swiper-pagination",
  },

  navigation: {
    nextEl: ".slider-swiper .swiper-button-next",
    prevEl: ".slider-swiper .swiper-button-prev",
  },
});

const homeProductSwiper = new Swiper(".home-product", {
  direction: "horizontal",
  slidesPerView: 4,
  grid: {
    rows: 2,
    fill: "row",
  },
  breakpoints: {
    200: {
      slidesPerView: 1,
      spaceBetween: 0,
    },
    375: {
      slidesPerView: 2,
      spaceBetween: 16,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 24,
    },
    1200: {
      slidesPerView: 4,
      spaceBetween: 32,
    },
  },
  spaceBetween: 32,
  navigation: {
    nextEl: ".home-product .swiper-button-next",
    prevEl: ".home-product .swiper-button-prev",
  },
});

const dataTabIdeas = document.querySelectorAll(".ideas-tab .ideas-item");
for (let i = 1; i <= dataTabIdeas.length; i++) {
  let nameSwiper = "IdeasSwiper" + i;
  const classSwiper = ".ideas-tab" + i + "-swiper";
  nameSwiper = new Swiper(classSwiper, {
    direction: "horizontal",
    speed: 1000,
    breakpoints: {
      200: {
        slidesPerView: 1,
      },
      480: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
      },
    },
    slidesPerView: 3,
    navigation: {
      nextEl: classSwiper + " .swiper-button-next",
      prevEl: classSwiper + " .swiper-button-prev",
    },
  });
}

const testimonialSwiper = new Swiper(".testimonial-swiper", {
  direction: "horizontal",
  slidesPerView: 2,
  spaceBetween: 32,
  speed: 1000,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  breakpoints: {
    200: {
      slidesPerView: 1,
    },
    480: {
      slidesPerView: 1,
    },
    992: {
      slidesPerView: 2,
      autoplay: false,
    },
  },
  navigation: {
    nextEl: ".testimonial-review .swiper-button-next",
    prevEl: ".testimonial-review .swiper-button-prev",
  },
});
