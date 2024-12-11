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
            console.log('Item removed successfully.');
            // Remove the product box
            const itemBox = document.getElementById(`product-${pid}`);
            if (itemBox) itemBox.remove();
        } else {
            console.error('Failed to remove item:', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
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
