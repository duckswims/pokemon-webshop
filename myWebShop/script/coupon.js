function redeemVoucher() {
    const couponCode = document.getElementById('coupon_code').value;
    const messageContainer = document.getElementById('message');

    fetch('shoppingCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `coupon_code=${encodeURIComponent(couponCode)}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            messageContainer.style.color = 'green';
        } else {
            messageContainer.style.color = 'red';
        }
        messageContainer.textContent = data.message;
    })
    .catch(error => {
        messageContainer.style.color = 'red';
        messageContainer.textContent = 'An error occurred. Please try again later.';
    });
}