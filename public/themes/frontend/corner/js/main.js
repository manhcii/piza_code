const buttonsCollapseMenu = document.querySelectorAll('.close-sub-nav')
Array.from(buttonsCollapseMenu).forEach((button) => {
    button.addEventListener('click', () => {
        button.parentElement.querySelector(".nav-item").classList.toggle('nav-item-bold')
        console.log(button.parentElement)
    }
)})

const quantityForms = document.querySelectorAll('.cart-quantity-form');
Array.from(quantityForms).forEach((quantityForm) => {
  const increButton = quantityForm.querySelector('.plus')
  const decreButton = quantityForm.querySelector('.minus')
  const inputQuantity = quantityForm.querySelector('input')
  increButton.addEventListener('click', () => {
    inputQuantity.value = Number(inputQuantity.value) + 1
  })

  decreButton.addEventListener('click', () => {
    if (inputQuantity.value > 1) {
      inputQuantity.value = inputQuantity.value - 1
    } else {
      inputQuantity.value = 1
    }
  })
})
