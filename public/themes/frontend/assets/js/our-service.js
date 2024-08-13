
function callSwiperExperience(){
    const experientcSwiperThumbs = new Swiper('.best-experienc-item.active .best-experienc-thumbs', {
        direction: 'vertical',
        slidesPerView: 7,
        spaceBetween: 10,
        speed: 1000,
        breakpoints: {
          0: {
            slidesPerView: 4,
            spaceBetween: 10,


          },
          375: {
            slidesPerView: 5,
            spaceBetween: 10,
          },
          768: {
            slidesPerView: 6,
            spaceBetween: 10,
          },
          1200: {
            slidesPerView: 7,
            spaceBetween: 10,
          }
        }
      });

    const experientcSwiperLarge = new Swiper('.best-experienc-item.active .best-experienc-large', {
    direction: 'horizontal',
    slidesPerView: 1,
    spaceBetween: 20,
    speed: 1000,
    thumbs: {
        swiper: experientcSwiperThumbs,
        },
    });

    return {experientcSwiperThumbs, experientcSwiperLarge}
}

  //Event click button experienc
  const buttonExperienc = document.querySelectorAll('.button-experienc')
  Array.from(buttonExperienc).forEach((button) => {
    button.addEventListener('click', () =>{
        //Event collapse
        const desExperienc = button.nextElementSibling
        const itemExperienc = button.closest('.best-experienc-item')

        //Xử lý nếu click ra ngoài button khác
        Array.from(buttonExperienc).forEach((buttonOr) => {
            const itemExperienc = buttonOr.closest('.best-experienc-item')
            const desExperienc = buttonOr.nextElementSibling

            if(button != buttonOr) {
                itemExperienc.classList.remove('active')
                desExperienc.style.maxHeight = null;
            }
        })

        if(desExperienc.style.maxHeight) {
            desExperienc.style.maxHeight = null;
        } else {
            desExperienc.style.maxHeight = desExperienc.scrollHeight + "px";
        }

        itemExperienc.classList.toggle('active')
        callSwiperExperience()
    })
  })

  Array.from(buttonExperienc)[0].click()
