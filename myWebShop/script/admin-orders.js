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
