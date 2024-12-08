document.addEventListener("DOMContentLoaded", () => {
    const cartIcon = document.getElementById("cart-icon");
    const cartCount = document.getElementById("cart-count");

    function updateCartIcon() {
        const itemCount = Object.values(window.collectionList).reduce((sum, item) => sum + item.quantity, 0);
        if (itemCount > 0) {
            cartCount.textContent = itemCount;
            cartCount.style.display = "inline";
        } else {
            cartCount.style.display = "none";
        }
    }

    // Expose updateCartIcon globally
    window.updateCartIcon = updateCartIcon;

    document.querySelectorAll(".add-cart").forEach(button => {
        button.addEventListener("click", () => {
            updateCartIcon();
        });
    });

    updateCartIcon();
});
