const hotNewsThumbSlider = new Swiper(
  "#fhm-blog-hot-news .hot-news-thumb .swiper",
  {
    direction: "vertical",
    slidesPerView: 3,
    loop: false,
    speed: 1000,
    spaceBetween: 25,
  }
);

const hotNewsContentSlider = new Swiper(
  "#fhm-blog-hot-news .hot-news-content .swiper",
  {
    direction: "horizontal",
    slidesPerView: 1,
    loop: false,
    speed: 1000,
    autoplay: {
      delay: 2000,
    },

    thumbs: {
      swiper: hotNewsThumbSlider,
    },

    breakpoints: {
      575: {
        direction: "vertical",
      },
    },
  }
);


