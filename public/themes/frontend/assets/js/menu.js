function callMansory() {
  const elem = document.querySelector(".components-menu-list");
  let gutterValue = 30; // Giá trị gutter mặc định

  if (window.innerWidth <= 480) {
    gutterValue = 10;
  } else if (window.innerWidth <= 992) {
    gutterValue = 20;
  }

  const msnry = new Masonry(elem, {
    // options
    itemSelector: ".components-menu-item",
    fitWidth: true,
    gutter: gutterValue,
  });
}
callMansory()

window.addEventListener("resize", () => {
  callMansory()
});
