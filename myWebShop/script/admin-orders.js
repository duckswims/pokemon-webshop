// Function to filter table rows based on search input and selected status filter
function searchOrders() {
    const searchInput = document.getElementById("search").value.toLowerCase();
    const statusFilter = document.getElementById("status-filter").value.toLowerCase();
    const rows = document.querySelectorAll("table tbody tr");

    rows.forEach(row => {
        const orderID = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
        const orderStatus = row.querySelector("td:nth-child(5) select").value.toLowerCase();
        
        // Check if the row matches the search and filter criteria
        const matchesSearch = orderID.includes(searchInput);
        const matchesStatus = statusFilter === "" || orderStatus === statusFilter;

        // Show or hide row based on the criteria
        if (matchesSearch && matchesStatus) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

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