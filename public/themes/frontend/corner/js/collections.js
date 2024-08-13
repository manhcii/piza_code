// Range slider
const filterRangeSlider = document.querySelector(
  "#fhm-list-product-products .products-filter-item .products-filter-item-range-slider"
);

const filterRangeSliderInputMin = document.querySelector(
  "#fhm-list-product-products .products-filter-item .products-filter-item-range-slider-input .min"
);
const filterRangeSliderInputMax = document.querySelector(
  "#fhm-list-product-products .products-filter-item .products-filter-item-range-slider-input .max"
);

const minusbtn = document.querySelectorAll(".minus");
minusbtn.forEach((minus) => {
  minus.addEventListener("click", () => {
    const quantity = minus.parentElement.querySelector(".qty");
    if (parseInt(quantity.value) > 0) {
      quantity.value = parseInt(quantity.value) - 1;
    }
  });
});

//filter
const filterItems = document.querySelectorAll(
  "#fhm-list-product-products .products-filter-item"
);


const checkboxItems = document.querySelectorAll(
  "#fhm-list-product-products .products-filter-item-criteria li"
);

filterItems.forEach((filterItem) => {
  // Clear Filter
  if (filterItem.querySelector(".clear-button")) {
    filterItem.querySelector(".clear-button").addEventListener("click", () => {
      filterItem
        .querySelectorAll(".products-filter-item-criteria li .checkbox")
        .forEach((checkbox) => {
          checkbox.setAttribute("data-status", "uncheck");
        });
    });
  }
});

checkboxItems.forEach((checkboxItem) => {
  // Select box
  checkboxItem.addEventListener("click", () => {
    if (
      checkboxItem.querySelector(".checkbox").getAttribute("data-status") ==
      "uncheck"
    ) {
      checkboxItem
        .querySelector(".checkbox")
        .setAttribute("data-status", "check");
    } else {
      checkboxItem
        .querySelector(".checkbox")
        .setAttribute("data-status", "uncheck");
    }
  });
});

rangeSlider(filterRangeSlider, {
  // min value
  min: 0,
  // max value
  max: 100,
  // step size
  step: 1,
  // set input value
  value: [0, 100],
  onInput: function (valueSet) {
    filterRangeSliderInputMin.value = valueSet[0];
    filterRangeSliderInputMax.value = valueSet[1];
  },
});

// Change range slider input value
const changeValue = () => {
  rangeSlider(filterRangeSlider).value([
    filterRangeSliderInputMin.value,
    filterRangeSliderInputMax.value,
  ]);
};

// Set default value input
filterRangeSliderInputMin.value = "min";
filterRangeSliderInputMax.value = "max";

// Render color
const colorCheckboxs = document.querySelectorAll(
  "#fhm-list-product-products .products-filter-item .products-filter-item-criteria li .checkbox-color"
);

colorCheckboxs.forEach((colorCheckbox) => {
  colorCheckbox.style.backgroundColor = `#${colorCheckbox.getAttribute(
    "data-color"
  )}`;
});

// Toggle mobile filter
const openFilterButton = document.querySelector(
  "#fhm-list-product-products .products-filter-toggle-button"
);

const closeFilterButton = document.querySelector(
  "#fhm-list-product-products .products-filter-toggle-button-close"
);

const productFilterList = document.querySelector(
  "#fhm-list-product-products .products-filter-list"
);

openFilterButton.addEventListener("click", () => {
  productFilterList.classList.add("active");
});

closeFilterButton.addEventListener("click", () => {
  productFilterList.classList.remove("active");
});

//Show content collection
const buttonShowContent = document.querySelector(
  ".collections-des-viewmore .button"
);
const desCollection = document.querySelector(".collections-content");
const heightDefault = desCollection.scrollHeight
console.log(heightDefault)
buttonShowContent.addEventListener("click", () => {

  if (buttonShowContent.textContent == "Collapsed") {
    buttonShowContent.textContent = "read more";
    desCollection.style.maxHeight = "145px"
  } else {
    buttonShowContent.textContent = "Collapsed";
    desCollection.style.maxHeight = heightDefault + 52 + "px"
  }
});
