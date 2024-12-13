function updateCartQty(pid, qty) {
    fetch('shoppingCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ pid: pid, qty: qty, action: 'update' }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.fetchCartCount(); // Update cart icon
            updateCartPrices(data); // Update prices dynamically
            console.log('Cart updated successfully.');
        } else {
            console.error('Failed to update cart:', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


function removeFromCart(pid) {
    fetch('shoppingCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ pid: pid, action: 'remove' }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const itemBox = document.getElementById(`product-${pid}`);
            if (itemBox) itemBox.remove();
            window.fetchCartCount(); // Dynamically update the cart icon
            updateCartPrices(data); // Update the prices on the page
            console.log('Item removed successfully.');
        } else {
            console.error('Failed to remove item:', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


function updateCartPrices(data) {
    // Update the Total Price (without tax)
    document.getElementById('totalPriceWOtax').textContent = `${data.totalPriceWOtax.toFixed(2)}€`;

    // Update the Tax
    document.getElementById('tax').textContent = `${data.tax.toFixed(2)}€`;

    // Update Subtotal
    document.getElementById('subtotal').textContent = `${data.totalPrice.toFixed(2)}€`;

    // Update Discount (conditionally)
    if (data.discount !== 0) {
        document.getElementById('discount').textContent = `- ${data.discount.toFixed(2)}€`;
        document.getElementById('discount').style.display = 'block'; // Show discount if non-zero
    } else {
        document.getElementById('discount').style.display = 'none'; // Hide discount if zero
    }

    // Update Shipping
    document.getElementById('shipping').textContent = `${data.shipping.toFixed(2)}€`;

    // Update the Final Price
    document.getElementById('finalPrice').textContent = `${data.finalPrice.toFixed(2)}€`;
}





document.addEventListener("DOMContentLoaded", () => {
    const proceedButton = document.querySelector(".payment");

    if (proceedButton) {
        proceedButton.addEventListener("click", () => {
            fetch("shoppingCart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    action: "proceed_to_payment",
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message); // Notify success
                        // Redirect to a confirmation page or clear the cart view
                        window.location.href = "orderHistory.php";
                    } else {
                        alert(data.error); // Notify error
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Something went wrong. Please try again.");
                });
        });
    }
});