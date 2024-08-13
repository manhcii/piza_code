//Mansory
function callMansory() {
    if(window.innerWidth >= 480){
        const elem = document.querySelector('.blog-tabs-content .active .list-blog');
        const msnry = new Masonry( elem, {
          // options
          itemSelector: '.blog-item',
          gutter: 32,
        });
    }
}



//Event load more
// function loadMore() {
//     const items = document.querySelectorAll('.blog-tabs-content .active .list-blog .hide-item')

//     Array.from(items).forEach((item, index) => {
//         if (index <= 3 ) {
//             item.classList.remove('hide-item')
//         }
//     })

//     callMansory()

//     return items.length
// }

//Hide items when start load document
function hideItems() {
    const items = document.querySelectorAll('.blog-tabs-content .active .list-blog .blog-item')
    const button = document.querySelector('.blog-tabs-content .active .load-more')
    //Hide button load more

    if(items.length < 7 && button) {
        button.style.display = 'none'
    }

    Array.from(items).forEach((item, index) => {
        if (index > 5 ) {
            item.classList.add('hide-item')
        }
    })

    callMansory()
}
hideItems()



// const buttons = document.querySelectorAll('.blog-tabs-content  .load-more')
// Array.from(buttons).forEach(button => {
//     button.addEventListener('click', () => {
//         const quantity = loadMore()
//         if(quantity <= 4 ) {
//             button.textContent = 'Collapse'

//         }

//         if( quantity == 0) {
//             button.textContent = 'See more'
//             hideItems()
//         }
//     })
// })

//Event click tabs
const tabs = document.querySelectorAll('.blogs-tab .blogs-tab-item')
Array.from(tabs).forEach(tab => {
    tab.addEventListener('click', () => {
        hideItems()
        callMansory()
    })
})

