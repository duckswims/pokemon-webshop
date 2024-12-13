<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: error.php?error=" . urlencode("You must be logged in as an admin to access this page."));
    exit();
}

// Handle status update if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderID'], $_POST['username'])) {
    $username = $_POST['username'];
    $orderID = $_POST['orderID'];
    $orderHistoryFile = "users/$username/orderHistory.json";

    if (file_exists($orderHistoryFile)) {
        $orderHistory = json_decode(file_get_contents($orderHistoryFile), true);

        foreach ($orderHistory as &$order) {
            if ($order['orderID'] === $orderID) {
                if (isset($_POST['process_order'])) $order['status'] = 'processing';
                if (isset($_POST['ship_order'])) $order['status'] = 'shipped';
                if (isset($_POST['received_order'])) $order['status'] = 'received';
                if (isset($_POST['cancelledReason'])) {
                    $order['status'] = 'cancelled';
                    $order['cancelledReason'] = $_POST['cancelledReason'];
                }
                break;
            }
        }
        file_put_contents($orderHistoryFile, json_encode($orderHistory, JSON_PRETTY_PRINT));
    }
}

// Load product data
$productData = json_decode(file_get_contents("json/product.json"), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p>Error reading product data.</p>";
    exit;
}

// Create a lookup array for product images
$productImages = array_column($productData["product"], "img_src", "pid");

// Get the list of all orders
$allOrders = [];
foreach (array_filter(scandir("users"), fn($item) => is_dir("users/$item") && $item !== '.' && $item !== '..') as $username) {
    $orderHistoryFile = "users/$username/orderHistory.json";
    if (file_exists($orderHistoryFile)) {
        $orderHistory = json_decode(file_get_contents($orderHistoryFile), true);
        foreach ($orderHistory as $order) {
            $order['username'] = $username;
            $allOrders[] = $order;
        }
    }
}

// Filter orders by status if set
$statusFilter = $_GET['status'] ?? '';
if ($statusFilter) {
    $allOrders = array_filter($allOrders, fn($order) => strtolower($order['status']) === strtolower($statusFilter));
}

// Sort orders by datetime
usort($allOrders, fn($a, $b) => strtotime($b['datetime']) - strtotime($a['datetime']));
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
                        <strong
                            class="<?php echo strtolower($order["status"]) === "completed" ? 'status-completed' : 
                                (strtolower($order["status"]) === "received" ? 'status-completed' : 
                                (in_array(strtolower($order["status"]), ['cancelled', 'returned']) ? 'status-cancelled-returned' : '')); ?>">
                            <?php echo htmlspecialchars(ucfirst($order["status"])); ?>
                        </strong>
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


                <!-- Display cancelled reason -->
                <?php if (strtolower($order["status"]) === "cancelled" && isset($order["cancelledReason"])): ?>
                <p class="cancelled-message" style="color: red;">
                    <?php echo strpos($order["cancelledReason"], $username) === 0 
                        ? "You have cancelled this order." 
                        : htmlspecialchars($order["cancelledReason"]); 
                    ?>
                </p>
                <?php endif; ?>


                <div style='display: flex; justify-content: center; gap: 10px;'>
                    <!-- View Button -->
                    <a href='order.php?orderID=<?php echo urlencode($order['orderID']); ?>'>
                        <button>View Order</button>
                    </a>
                    <!-- Process Order -->
                    <?php if (strtolower($order["status"]) === "confirmed"): ?>
                    <form method="POST">
                        <input type="hidden" name="username"
                            value="<?php echo htmlspecialchars($order['username']); ?>">
                        <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($order['orderID']); ?>">
                        <input type="hidden" id="shippedStatus" name="process_order" value="processing">
                        <button type="submit" class="btn-blue">Process Order</button>
                    </form>
                    <?php endif; ?>
                    <?php if (!in_array(strtolower($order["status"]), ["shipped", "cancelled", "received"])): ?>
                    <!-- Ship Order Form -->
                    <form method="POST" onsubmit="return confirmShip();">
                        <input type="hidden" name="username"
                            value="<?php echo htmlspecialchars($order['username']); ?>">
                        <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($order['orderID']); ?>">
                        <input type="hidden" id="shippedStatus" name="ship_order" value="shipped">
                        <button type="submit" class="btn-blue">Ship Order</button>
                    </form>
                    <!-- Cancel Order Form -->
                    <form method="POST" onsubmit="return confirmCancel();">
                        <input type="hidden" name="username"
                            value="<?php echo htmlspecialchars($order['username']); ?>">
                        <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($order['orderID']); ?>">
                        <input type="hidden" id="cancelledReason" name="cancelledReason" value="">
                        <button type="submit" name="cancel_order" class="btn-red">Cancel Order</button>
                    </form>
                    <?php endif; ?>
                    <!-- Received Order Form -->
                    <?php if (strtolower($order["status"]) === "shipped"): ?>
                    <form method="POST">
                        <input type="hidden" name="username"
                            value="<?php echo htmlspecialchars($order['username']); ?>">
                        <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($order['orderID']); ?>">
                        <input type="hidden" id="shippedStatus" name="received_order" value="received">
                        <button type="submit" class="btn-green">Received Order</button>
                    </form>
                    <?php endif; ?>
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