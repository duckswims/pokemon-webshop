// Function to update the quantity of an item in the cart
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
                console.log(data);
                window.fetchCartCount(); // Update cart icon
                updateCartPrices(data); // Dynamically update prices
                console.log('Cart updated successfully.');
            } else {
                console.error('Failed to update cart:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Function to remove an item from the cart
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
                if (itemBox) itemBox.remove(); // Remove the item from the DOM

                window.fetchCartCount(); // Update cart icon dynamically
                updateCartPrices(data); // Update prices dynamically
                console.log('Item removed successfully.');
            } else {
                console.error('Failed to remove item:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Function to update cart prices dynamically
function updateCartPrices(data) {
    document.getElementById('totalPriceWOtax').textContent = `${data.totalPriceWOtax.toFixed(2)}€`;
    document.getElementById('tax').textContent = `${data.tax.toFixed(2)}€`;
    document.getElementById('subtotal').textContent = `${data.totalPrice.toFixed(2)}€`;
    document.getElementById('shipping').textContent = `${data.shipping.toFixed(2)}€`;
    document.getElementById('finalPrice').textContent = `${data.finalPrice.toFixed(2)}€`;

    if (data.discount > 0) {
        document.getElementById('discount').textContent = `${data.discount.toFixed(2)}€`;
    }

    // Dynamically display the "Free shipping after 1000€" message
    const shippingMessage = document.getElementById('shippingMessage');
    if (data.totalPrice < 1000) {
        shippingMessage.style.display = 'block';
    } else {
        shippingMessage.style.display = 'none';
    }
}

// Add event listener for the "Proceed to Payment" button
document.addEventListener('DOMContentLoaded', () => {
    const proceedButton = document.querySelector('.payment');

    if (proceedButton) {
        proceedButton.addEventListener('click', () => {
            fetch('shoppingCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'proceed_to_payment',
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message); // Notify user of success

                        // Redirect to order history or update the view
                        window.location.href = 'orderHistory.php';
                    } else {
                        alert(data.error); // Notify user of the error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                });
        });
    }
});
