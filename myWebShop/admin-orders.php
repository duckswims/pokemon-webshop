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

// Load product data for images
$productDataPath = "json/product.json"; // Path to product.json
$productData = json_decode(file_get_contents($productDataPath), true);

// Check if the JSON is valid
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p>Error reading product data.</p>";
    exit;
}

// Create a lookup array for product images
$productImages = [];
foreach ($productData["product"] as $product) {
    $productImages[$product["pid"]] = $product["img_src"];
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

// Check if a status filter is set
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Filter the orders based on the selected status
if ($statusFilter) {
    $allOrders = array_filter($allOrders, function ($order) use ($statusFilter) {
        return strtolower($order['status']) === strtolower($statusFilter);
    });
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
    <link rel="stylesheet" href="styles/order-display.css">
    <link rel="stylesheet" href="styles/order-status.css">
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
            <select id="status-filter" onchange="window.location.href = '?status=' + this.value">
                <option value="">All</option>
                <option value="processing" <?php echo ($statusFilter === 'processing' ? 'selected' : ''); ?>>Processing
                </option>
                <option value="shipped" <?php echo ($statusFilter === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                <option value="completed" <?php echo ($statusFilter === 'completed' ? 'selected' : ''); ?>>Completed
                </option>
                <option value="returned" <?php echo ($statusFilter === 'returned' ? 'selected' : ''); ?>>Returned
                </option>
                <option value="cancelled" <?php echo ($statusFilter === 'cancelled' ? 'selected' : ''); ?>>Cancelled
                </option>
            </select>
        </div>
        <br>

        <div class="order-display container" id="order-display">
            <?php
            if (count($allOrders) > 0) {
                // Display each order in the updated display format
                foreach ($allOrders as $order) {
                    // Round the total price to 2 decimal places
                    $totalPrice = number_format($order['totalPrice'], 2);
                    ?>
            <div class='box order-display-box'>
                <div class='container'>
                    <div class='left'>
                        <strong>Order ID: <?php echo htmlspecialchars($order["orderID"]); ?></strong>
                        <p>Date: <?php echo htmlspecialchars($order["datetime"]); ?></p>
                    </div>
                    <div class='right'>
                        <!-- Status Form -->
                        <form method="POST">
                            <input type="hidden" name="username"
                                value="<?php echo htmlspecialchars($order['username']); ?>">
                            <input type="hidden" name="orderID"
                                value="<?php echo htmlspecialchars($order['orderID']); ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="processing"
                                    <?php echo ($order['status'] === 'processing' ? 'selected' : ''); ?>>Processing
                                </option>
                                <option value="shipped"
                                    <?php echo ($order['status'] === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                                <option value="completed"
                                    <?php echo ($order['status'] === 'completed' ? 'selected' : ''); ?>>Completed
                                </option>
                                <option value="returned"
                                    <?php echo ($order['status'] === 'returned' ? 'selected' : ''); ?>>Returned</option>
                                <option value="cancelled"
                                    <?php echo ($order['status'] === 'cancelled' ? 'selected' : ''); ?>>Cancelled
                                </option>
                            </select>
                        </form>
                        <?php $finalPrice = $order["totalPrice"] - $order["discount"] + $order["shipping"]; ?>
                        <p><?php echo htmlspecialchars(number_format($finalPrice, 2) . '€'); ?></p>
                    </div>
                </div>

                <!-- Order Product Images -->
                <div class='order-product-items'>
                    <?php
                            // Display product images and quantities
                            foreach ($order["cart"] as $item) {
                                if (isset($productImages[$item["pid"]])) {
                                    ?>
                    <div class='order-product-item'>
                        <p class='order-qty'><?php echo htmlspecialchars($item["qty"]); ?></p>
                        <img src='<?php echo htmlspecialchars($productImages[$item["pid"]]); ?>' alt='Product Image' />
                    </div>
                    <?php
                                }
                            }
                            ?>
                </div>

                <div style='display: flex; justify-content: center;'>
                    <a href='order.php?orderID=<?php echo urlencode($order['orderID']); ?>'>
                        <button>View Order</button>
                    </a>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>No orders found.</p>";
            }
            ?>
        </div>

    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>

</body>

</html>