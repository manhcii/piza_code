
const alsoLikeProduct = new Swiper('.product-like', {
    direction: 'horizontal',
    slidesPerView: 4,
    spaceBetween: 32,
    breakpoints: {
      200: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      320:{
        slidesPerView: 2,
        spaceBetween: 16,
      },
      480:{
        slidesPerView: 3,
        spaceBetween: 24,
      },
      992:{
        slidesPerView: 4,
        spaceBetween: 32,
      }
    },
    navigation: {
      nextEl: '.product-like .swiper-button-next',
      prevEl: '.product-like .swiper-button-prev',
    },
  });

