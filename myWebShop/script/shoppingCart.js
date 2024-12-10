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
            // Optionally, remove the item from the UI
            const itemBox = document.getElementById(`delete-${pid}`).closest('.box');
            if (itemBox) itemBox.remove();
        } else {
            console.error('Failed to remove item:', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
