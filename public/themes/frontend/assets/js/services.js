const servicesBlockSlider = new Swiper(
  "#fhm-services .services-block-2 .services-block-slider .swiper",
  {
    direction: "horizontal",
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
    speed: 500,
    autoplay: {
      delay: 2000,
    },
    navigation: {
      nextEl: ".slider-button-next",
      prevEl: ".slider-button-prev",
    },
    breakpoints: {
      1399: {
        speed: 750,
        direction: "vertical",
      },
    },
  }
);



// SHOW IMAGES
const imagesArr = document.querySelectorAll(
  "#fhm-services .services-block-2 .services-slider-item img"
);
const bigImage = document.querySelector(
  "#fhm-services .services-block-2 .services-block-image"
);

imagesArr.forEach((image) => {
  image.addEventListener("click", () => {
    bigImage.style.backgroundImage = `url(${image.getAttribute("src")})`;
  });
});
