document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchOrderID');
    const orderItems = document.querySelectorAll('.box.order-display-box'); // All order boxes

    searchInput.addEventListener('input', function() {
        const searchValue = searchInput.value.toLowerCase();

        orderItems.forEach(function(order) {
            const orderID = order.querySelector('.left strong').textContent.toLowerCase();
            
            if (orderID.includes(searchValue)) {
                order.style.display = '';  // Show the order
            } else {
                order.style.display = 'none';  // Hide the order
            }
        });
    });
});