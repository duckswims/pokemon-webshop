// Function to filter table rows based on search input and selected status filter
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("search");
    const rows = document.querySelectorAll(".order-display .order-display-box");

    function searchOrders() {
        const searchQuery = searchInput.value.toLowerCase().trim();

        rows.forEach(row => {
            const orderIDElement = row.querySelector(".left strong");
            const orderID = orderIDElement ? orderIDElement.textContent.toLowerCase() : "";

            // Show or hide the row based on the search query
            if (orderID.includes(searchQuery)) {
                row.style.display = "block";
            } else {
                row.style.display = "none";
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener("input", searchOrders);
    }
});

function confirmCancel() {
    // Retrieve the orderID and username from hidden form fields
    const orderID = document.querySelector('input[name="orderID"]').value;
    const username = document.querySelector('input[name="username"]').value;

    // Show the options in a prompt (can be customized with a modal if needed)
    const reason = prompt("Select a cancellation reason:");
    document.querySelector('input[name="cancelledReason"]').value = reason;
    document.querySelector('form').submit();
}


function confirmShip() {
    return confirm("Are you sure you want to mark this order as shipped?");
}