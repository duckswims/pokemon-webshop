function filterProducts() {
    const searchInput = document.getElementById('search-field').value.toLowerCase();
    const productBoxes = document.querySelectorAll('.product-box');

    productBoxes.forEach(box => {
        const pid = box.getAttribute('data-pid');
        const name = box.getAttribute('data-name');

        if (pid.includes(searchInput) || name.includes(searchInput)) {
            box.style.display = "block";
        } else {
            box.style.display = "none";
        }
    });
}
