document.addEventListener("DOMContentLoaded", () => {
    const cartCountSpan = document.getElementById("cart-count");

    // Function to update cart count dynamically
    function updateCartCount(newCartCount) {
        cartCountSpan.textContent = newCartCount;
        cartCountSpan.style.display = newCartCount > 0 ? "inline" : "none";
    }

    // Fetch and update cart count on page load
    function fetchCartCount() {
        fetch("shoppingCart.php?action=getCartCount")
            .then(response => response.json())
            .then(data => {
                if (data.success && typeof data.cartCount !== "undefined") {
                    updateCartCount(data.cartCount);
                }
            })
            .catch(error => console.error("Error fetching cart count:", error));
    }

    // Initialize the cart count
    fetchCartCount();

    // Expose the function globally (if needed)
    window.fetchCartCount = fetchCartCount;
    // window.updateCartCount = updateCartCount;
});
