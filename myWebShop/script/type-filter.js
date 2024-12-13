function filterTypes(text) {
    const productBoxes = document.querySelectorAll('.product-box');

       productBoxes.forEach(box => {
        const type = JSON.parse(box.dataset.type);

        if (type.includes(text)) {
            box.style.display = "block";
        } else {
            box.style.display = "none";
        }
        }); 
}
