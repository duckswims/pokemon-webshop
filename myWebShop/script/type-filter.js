function filterTypes(text) {
    const productBoxes = document.querySelectorAll('.product-box');

       productBoxes.forEach(box => {
        const type = JSON.parse(box.dataset.type);

        if (type.includes(text)) {
            box.style.display = "flex";
        } else {
            box.style.display = "none";
        }
        }); 
}

function resetFilter() {
    const productBoxes = document.querySelectorAll('.product-box');
    const searchInput = document.getElementById("search-field");

    searchInput.value = null;
        productBoxes.forEach(box => {
            box.style.display = "flex";
        }); 
}