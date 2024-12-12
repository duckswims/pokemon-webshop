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

// Check if the file exists
if (!file_exists($orderHistoryPath)) {
    echo "<p>No order history found for user: $username</p>";
    exit;
}

// Load the JSON file
$orderHistory = json_decode(file_get_contents($orderHistoryPath), true);

// Check if the JSON is valid
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p>Error reading order history data.</p>";
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
    <link rel="stylesheet" href="styles/orderHistory.css">
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <h1>Your Order History</h1>

        <div class="order-display" id="order-display">
            <?php foreach ($orderHistory as $order): ?>
            <div class="box product-box">
                <p>Status: <?php echo htmlspecialchars($order["status"]); ?></p>
                <p>Order ID: <?php echo htmlspecialchars($order["orderID"]); ?></p>
                <p>Date: <?php echo htmlspecialchars($order["datetime"]); ?></p>
                <p>Total Price: <?php echo htmlspecialchars(number_format($order["totalPrice"], 2)); ?> USD</p>
                <button>View Order</button>
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