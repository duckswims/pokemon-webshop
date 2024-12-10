// document.addEventListener("DOMContentLoaded", () => {
//     const cartIcon = document.getElementById("cart-icon");
//     const cartCount = document.getElementById("cart-count");

//     function updateCartIcon() {
//         const itemCount = Object.values(window.collectionList).reduce((sum, item) => sum + item.quantity, 0);
//         if (itemCount > 0) {
//             cartCount.textContent = itemCount;
//             cartCount.style.display = "inline";
//         } else {
//             cartCount.style.display = "none";
//         }
//     }

//     // Expose updateCartIcon globally
//     window.updateCartIcon = updateCartIcon;

//     document.querySelectorAll(".add-cart").forEach(button => {
//         button.addEventListener("click", () => {
//             updateCartIcon();
//         });
//     });

//     updateCartIcon();
// });

document.addEventListener("DOMContentLoaded", () => {
    const cartCountSpan = document.getElementById("cart-count");
    let cartCount = parseInt(cartCountSpan.textContent);

    if (cartCount > 0) {
        cartCountSpan.style.display = "inline";
        cartCountSpan.textContent = cartCount;
    }
});

function updateCartCount(newCartCount) {
    const cartCountSpan = document.getElementById("cart-count");
    cartCountSpan.textContent = newCartCount;
    cartCountSpan.style.display = newCartCount > 0 ? "inline" : "none";
}

function handleAddToCartResponse(response) {
    if (response.success) {
        updateCartCount(response.cartCount);
    }
}

document.querySelector('.add-to-cart').addEventListener('click', function () {
    const pid = this.dataset.pid;
    const quantity = 1;

    fetch('all-products.php', {
        method: 'POST',
        body: JSON.stringify({ pid: pid, quantity: quantity }),
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => handleAddToCartResponse(data));
});

