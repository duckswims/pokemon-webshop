<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in and is an admin
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : false;

// If the user is not logged in or not an admin, redirect to error.php
if (!$admin) {
    // Redirect to error page with a query parameter for the error message
    header("Location: error.php?error=You must be logged in as an admin to access this page.");
    exit();
}
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
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <main>
        <h1>Orders</h1>

        <?php
        $directory = "users"; // Replace with actual path

        // Get the list of directories (usernames)
        $usernames = array_filter(scandir($directory), function ($item) use ($directory) {
            return is_dir($directory . '/' . $item) && $item !== '.' && $item !== '..';
        });

        $allOrders = [];

        // Iterate through each user's directory and get the order history
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

        if (count($allOrders) > 0) {
            echo "<h2>Order History:</h2>";
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Order ID</th>
                            <th>Datetime</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Display each order
            foreach ($allOrders as $order) {
                echo "<tr>
                        <td>" . htmlspecialchars($order['username']) . "</td>
                        <td>" . htmlspecialchars($order['orderID']) . "</td>
                        <td>" . htmlspecialchars($order['datetime']) . "</td>
                        <td>" . htmlspecialchars($order['totalPrice']) . "</td>
                        <td>" . htmlspecialchars($order['status']) . "</td>
                        <td><button class='btn-red' onclick='viewOrderDetails(\"" . htmlspecialchars($order['orderID']) . "\")'>View Details</button></td>
                    </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No orders found.</p>";
        }
        ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>

    <script>
    // JavaScript function to view the order details
    function viewOrderDetails(orderID) {
        alert('Details for order ' + orderID);
        // Here you can implement a feature to show detailed information about the order, such as a modal or new page.
    }
    </script>
</body>

</html>