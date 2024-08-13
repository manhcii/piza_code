//Event load more
function loadMore() {
    const items = document.querySelectorAll('.tabs-menu-content .active .tabs-menu-products .hide-item')

    Array.from(items).forEach((item, index) => {
        if (index <= 2 ) {
            item.classList.remove('hide-item')
        }
    })

    return items.length
}

//Hide items when start load document
function hideItems() {
    const items = document.querySelectorAll('.tabs-menu-content .active .tabs-menu-products .product-item')
    const button = document.querySelector('.tabs-menu-content .active .load-more')
    //Hide button load more

    if(items.length < 10 && button) {
        button.style.display = 'none'
    }

    Array.from(items).forEach((item, index) => {
        if (index > 8 ) {
            item.classList.add('hide-item')
        }
    })

}
hideItems()


const buttons = document.querySelectorAll('.tabs-menu-content  .load-more')
Array.from(buttons).forEach(button => {
    button.addEventListener('click', () => {
        const quantity = loadMore()
        if(quantity <= 4 ) {
            button.textContent = 'Collapse'

        }

        if( quantity == 0) {
            button.textContent = 'Load more'
            hideItems()
        }
    })
})

//Event click tabs
const tabs = document.querySelectorAll('.tabs-menu-list .tabs-menu-button')
Array.from(tabs).forEach(tab => {
    tab.addEventListener('click', () => {
        hideItems()
    })
})

