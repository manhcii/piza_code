const swiperThumbImage = new Swiper(".thumb-image-swiper", {
  spaceBetween: 16,
  direction: "vertical",
  speed: 1000,
  slidesPerView: 4,
  freeMode: true,
  breakpoints: {
    200: {
      direction: "horizontal",
    },
    1200: {
      direction: "vertical",
    },
  },
  navigation: {
    nextEl: ".thumb-image-swiper .swiper-button-next",
    prevEl: ".thumb-image-swiper .swiper-button-prev",
  },
  watchSlidesProgress: true,
});

const dataColors = ["EAE0D0", "E5E9EA", "F0E7E0", "DDDACB", "BDC3B9", "D2DDE3"];
const swiperLargeImage = new Swiper(".large-image-swiper", {
  spaceBetween: 0,
  speed: 1000,
  direction: "horizontal",
  pagination: {
    el: ".variant-color-list",
    clickable: true,
    renderBullet: function (index, className) {
      return (
        '<li class="variant-item swiper-pagination-bullet">' + '<input type="radio" name="color"  data-color="'+ dataColors[index] +'"/>' + "</li>"
      );
    }
  },
  thumbs: {
    swiper: swiperThumbImage,
  },
});

const colorCheckboxsProduct = document.querySelectorAll(
  ".variant-color-list .variant-item input"
);
colorCheckboxsProduct.forEach((colorCheckbox) => {
  colorCheckbox.style.backgroundColor = `#${colorCheckbox.getAttribute(
    "data-color"
  )}`;
});

const relatedProduct = new Swiper(".product-related", {
  direction: "horizontal",
  slidesPerView: 4,
  spaceBetween: 32,
  speed: 1000,
  autoplay: {
    delay: 2000,
  },
  breakpoints: {
    200: {
      slidesPerView: 1,
      spaceBetween: 10,
    },
    320: {
      slidesPerView: 2,
      spaceBetween: 16,
    },
    480: {
      slidesPerView: 3,
      spaceBetween: 24,
    },
    992: {
      slidesPerView: 4,
      spaceBetween: 32,
    },
  },
  navigation: {
    nextEl: ".product-related .swiper-button-next",
    prevEl: ".product-related .swiper-button-prev",
  },
});
