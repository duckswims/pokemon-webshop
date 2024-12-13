<?php
// Start the session to access session variables
session_start();

// Check if username exists in session
if (!isset($_SESSION["username"])) {
    echo "<p>Please log in to view your order history.</p>";
    exit;
}

$username = $_SESSION["username"];
$orderHistoryPath = "users/$username/orderHistory.json";
$productDataPath = "json/product.json";  // Path to product.json

// Check if the order history file exists
if (!file_exists($orderHistoryPath)) {
    echo "<p>No order history found for user: $username</p>";
    exit;
}

// Load the JSON files
$orderHistory = json_decode(file_get_contents($orderHistoryPath), true);
$productData = json_decode(file_get_contents($productDataPath), true);

// Check if the JSON is valid
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p>Error reading order history or product data.</p>";
    exit;
}

// Sort the order history by datetime (newest first)
usort($orderHistory, function ($a, $b) {
    return strtotime($b["datetime"]) - strtotime($a["datetime"]);
});

// Create a lookup array for product images
$productImages = [];
foreach ($productData["product"] as $product) {
    $productImages[$product["pid"]] = $product["img_src"];
}

// Function to update order status
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["orderID"]) && isset($_POST["status"])) {
    $orderID = $_POST["orderID"];
    $newStatus = $_POST["status"];
    
    // Update the order status and set the cancelled reason if applicable
    foreach ($orderHistory as &$order) {
        if ($order["orderID"] === $orderID) {
            $order["status"] = $newStatus;
            if ($newStatus === "cancelled") {
                $order["cancelledReason"] = "$username has cancelled this order.";
            }
        }
    }
    
    // Save the updated order history back to the file
    file_put_contents($orderHistoryPath, json_encode($orderHistory, JSON_PRETTY_PRINT));
    
    // Refresh the page to display the updated status
    header("Location: orderHistory.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Store - Order History</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/order-display.css">
    <link rel="stylesheet" href="styles/order-status.css">
    <script src="script/orderHistory.js"></script>
    <script src="script/cancel-order.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <h1>Your Order History</h1>

        <!-- Search for Order ID -->
        <div class="order-search container">
            <label for="searchOrderID">Search Order ID:</label>
            <input type="text" id="searchOrderID" placeholder="Enter Order ID" />
        </div>

        <!-- Order Display -->
        <div class="order-display container" id="order-display">
            <?php foreach ($orderHistory as $order): ?>
            <div class="box order-display-box">
                <div class="container">
                    <div class="left">
                        <strong>Order ID: <?php echo htmlspecialchars($order["orderID"]); ?></strong>
                        <p>Date: <?php echo htmlspecialchars($order["datetime"]); ?></p>
                    </div>
                    <div class="right">
                        <strong
                            class="<?php echo strtolower($order["status"]) === "completed" ? 'status-completed' : (in_array(strtolower($order["status"]), ['cancelled', 'returned']) ? 'status-cancelled-returned' : ''); ?>">
                            <?php echo htmlspecialchars(ucfirst($order["status"])); ?>
                        </strong>
                        <p>Total Price: <?php echo htmlspecialchars(number_format($order["totalPrice"], 2)); ?> €</p>
                    </div>
                </div>

                <!-- Order Product Images -->
                <div class="order-product-items">
                    <?php foreach ($order["cart"] as $item): ?>
                    <?php if (isset($productImages[$item["pid"]])): ?>
                    <div class="order-product-item">
                        <p class="order-qty"><?php echo htmlspecialchars($item["qty"]); ?></p>
                        <img src="<?php echo htmlspecialchars($productImages[$item["pid"]]); ?>" alt="Product Image" />
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
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

                <div style="display: flex; justify-content: center; gap: 10px;">
                    <!-- View Order -->
                    <a href="order.php?orderID=<?php echo urlencode($order['orderID']); ?>">
                        <button class="btn-blue">View Order</button>
                    </a>
                    <!-- Cancel Order Button (if status is "processing") -->
                    <?php if (in_array(strtolower($order["status"]), ["processing", "confirmed"])): ?>
                    <form action="orderHistory.php" method="POST">
                        <input type="hidden" name="orderID"
                            value="<?php echo htmlspecialchars($order["orderID"]); ?>" />
                        <input type="hidden" name="status" value="cancelled" />
                        <button type="submit" class="btn-red">Cancel Order</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>