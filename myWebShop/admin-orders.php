<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in and is an admin
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : false;

// If the user is not logged in or not an admin, redirect to error.php
if (!$admin) {
    // Redirect to error page with a query parameter for the error message
    header("Location: error.php?error=" . urlencode("You must be logged in as an admin to access this page."));
    exit();
}

// Handle status update if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderID'], $_POST['status'], $_POST['username'])) {
    $username = $_POST['username'];
    $orderID = $_POST['orderID'];
    $newStatus = $_POST['status'];

    $orderHistoryFile = "users/$username/orderHistory.json";

    if (file_exists($orderHistoryFile)) {
        $orderHistory = json_decode(file_get_contents($orderHistoryFile), true);

        // Update the status for the matching order ID
        foreach ($orderHistory as &$order) {
            if ($order['orderID'] === $orderID) {
                $order['status'] = $newStatus;
                break;
            }
        }

        // Save the updated order history back to the file
        file_put_contents($orderHistoryFile, json_encode($orderHistory, JSON_PRETTY_PRINT));
    }
}

// Get the list of all orders
$directory = "users"; // Replace with actual path
$usernames = array_filter(scandir($directory), function ($item) use ($directory) {
    return is_dir($directory . '/' . $item) && $item !== '.' && $item !== '..';
});

$allOrders = [];
foreach ($usernames as $username) {
    $orderHistoryFile = $directory . '/' . $username . '/orderHistory.json';

    // Check if orderHistory.json exists and read it
    if (file_exists($orderHistoryFile)) {
        $orderHistory = json_decode(file_get_contents($orderHistoryFile), true);

        // Add each order to the list of all orders
        foreach ($orderHistory as $order) {
            // Add user info to each order
            $order['username'] = $username;
            $allOrders[] = $order;
        }
    }
}

// Sort the orders by 'datetime' in descending order
usort($allOrders, function ($a, $b) {
    return strtotime($b['datetime']) - strtotime($a['datetime']);
});
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/admin-orders.css">
    <script src="script/admin-orders.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <main>
        <h1>Orders</h1>

        <!-- Dynamic order search input and status filter -->
        <div id="search-container" class="container">
            <label for="search">Search by Order ID:</label>
            <input type="text" id="search" oninput="searchOrders()" placeholder="Search orders by Order ID">

            <!-- Add a status filter dropdown -->
            <label for="status-filter">Filter by Status:</label>
            <select id="status-filter" onchange="searchOrders()">
                <option value="">All</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="completed">Completed</option>
                <option value="returned">Returned</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <br>

        <?php
        if (count($allOrders) > 0) {
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Order ID</th>
                            <th>Date Ordered</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Display each order
            foreach ($allOrders as $order) {
                // Round the total price to 2 decimal places
                $totalPrice = number_format($order['totalPrice'], 2);

                // Determine the row color based on the status
                $rowColor = '';
                if ($order['status'] === 'cancelled' || $order['status'] === 'returned') {
                    $rowColor = 'style="background-color: red; color: white;"';
                } elseif ($order['status'] === 'completed') {
                    $rowColor = 'style="background-color: green; color: white;"';
                } elseif ($order['status'] === 'shipped') {
                    $rowColor = 'style="background-color: blue; color: white;"';
                }

                echo "<tr $rowColor>
                        <td>" . htmlspecialchars($order['username']) . "</td>
                        <td>" . htmlspecialchars($order['orderID']) . "</td>
                        <td>" . htmlspecialchars($order['datetime']) . "</td>
                        <td style='text-align: right;'>" . $totalPrice . "€</td>
                        <td>
                            <form method='POST'>
                                <input type='hidden' name='username' value='" . htmlspecialchars($order['username']) . "'>
                                <input type='hidden' name='orderID' value='" . htmlspecialchars($order['orderID']) . "'>
                                <select name='status' onchange='this.form.submit()'>
                                    <option value='processing'" . ($order['status'] === 'processing' ? ' selected' : '') . ">Processing</option>
                                    <option value='shipped'" . ($order['status'] === 'shipped' ? ' selected' : '') . ">Shipped</option>
                                    <option value='completed'" . ($order['status'] === 'completed' ? ' selected' : '') . ">Completed</option>
                                    <option value='returned'" . ($order['status'] === 'returned' ? ' selected' : '') . ">Returned</option>
                                    <option value='cancelled'" . ($order['status'] === 'cancelled' ? ' selected' : '') . ">Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href=\"order.php?orderID=" . urlencode($order['orderID']) . "\">
                                <button class=''>View Details</button>
                            </a>
                        </td>
                    </tr>";
            }


            echo "</tbody>
                  </table>";
        } else {
            echo "<p>No orders found.</p>";
        }
        ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>

</body>

</html>