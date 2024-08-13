const buttonsCollapseMenu = document.querySelectorAll('.close-sub-nav')
Array.from(buttonsCollapseMenu).forEach((button) => {
    button.addEventListener('click', () => {
        button.parentElement.querySelector(".nav-item").classList.toggle('nav-item-bold')
    }
)})


//Xử lý các ô input
const inputs = document.querySelectorAll('form input[type="text"], form input[type="email"]');
  Array.from(inputs).forEach((input) => {
    const placeHolderCurrent = input.getAttribute('placeholder') || "";
    input.addEventListener('focus', function(){
      const clearInput = this.nextElementSibling;

      this.setAttribute('placeholder', '');
      clearInput.classList.remove('d-none')

      //Xử lý sự kiện khi thay đổi input hiển thị nút X
      this.addEventListener('input', function(){
        if ( this.value == '' ) {
          clearInput.querySelector('svg path').style.fill = "#c8c8c8"
        } else {
          clearInput.querySelector('svg path').style.fill = "#000"
        }
      });

      //Xử lý sự kiện khi clear input
      clearInput.addEventListener('click', ()=> {
        clearInput.previousElementSibling.value = '';
        clearInput.querySelector('svg path').style.fill = "#c8c8c8";
        input.focus()
      });

      //Xử lý sự kiện khi click ra ngoài ô input khác
      window.addEventListener('click', (e) => {
        if ( e.target.closest('.contact-form-line') == input.closest('.contact-form-line')) {
            return false;
          } else {
            clearInput.classList.add('d-none')
          }
      })
    });

    //Hiển thị lại place holder
    input.addEventListener('focusout', function(e) {
    this.setAttribute('placeholder', placeHolderCurrent);
    })
});

const textareaInputs = document.querySelectorAll('form textarea');
Array.from(textareaInputs).forEach((textarea) => {
  const placeHolderCurrent = textarea.getAttribute('placeholder') || "";
  textarea.addEventListener('focus', function(){
    this.setAttribute('placeholder', '');
  })

  //Hiển thị lại place holder
  textarea.addEventListener('focusout', function(e) {
    this.setAttribute('placeholder', placeHolderCurrent);
  })
})


  //Event click video book
//   const video = document.querySelector('.book-apppointment-video video')
//   const buttonPlayVideo = document.querySelector('.book-apppointment-video .play-video')
//   const imageVideo = document.querySelector('.book-apppointment-video-image')
//   if(buttonPlayVideo) {
//     buttonPlayVideo.addEventListener('click', () => {
//       buttonPlayVideo.classList.add('visible-element')
//       imageVideo.classList.add('visible-element')
//       video.setAttribute('src', '/themes/frontend/assets/videos/book-appoitment.mp4')
//       video.setAttribute('controls', '')
//     })
//   }
