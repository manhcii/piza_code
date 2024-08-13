const articleRelatedSwiper = new Swiper('.article-related-swiper', {
    direction: 'horizontal',
    slidesPerView: 3,
    spaceBetween: 32,
    breakpoints: {
      200:{
        slidesPerView: 1,
      },
      480:{
        slidesPerView: 2,
      },
      992:{
        slidesPerView: 3,
      }
    },
    navigation: {
      nextEl: '.aricle-related-wrap .swiper-button-next',
      prevEl: '.aricle-related-wrap .swiper-button-prev',
    },
  });