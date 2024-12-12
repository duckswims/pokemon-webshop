<?php
// Start the session to access session variables
session_start();

// Initialize error message
$errorMessage = "";

// Check if user is logged in and has a username in session
if (!isset($_SESSION["username"])) {
    $errorMessage = "Access denied. Please log in.";
    header("Location: error.php?error=" . urlencode($errorMessage));
    exit;
}

// Get the username from the session if available
$username = $_SESSION["username"];

// Get the orderID from the query string
$orderID = isset($_GET["orderID"]) ? htmlspecialchars($_GET["orderID"]) : null;

// Path to the user's order history JSON file
$orderHistoryPath = "users/$username/orderHistory.json";

// Check if the order history file exists
if (!file_exists($orderHistoryPath)) {
    $errorMessage = "Error: Order history not found.";
    header("Location: error.php?error=" . urlencode($errorMessage));
    exit;
}

// Read and decode the JSON file
$orderHistory = json_decode(file_get_contents($orderHistoryPath), true);
if ($orderHistory === null) {
    $errorMessage = "Error: Unable to parse order history.";
    header("Location: error.php?error=" . urlencode($errorMessage));
    exit;
}

// Search for the order by orderID
$order = null;
foreach ($orderHistory as $o) {
    if ($o["orderID"] === $orderID) {
        $order = $o;
        break;
    }
}

if (!$order) {
    $errorMessage = "Order not found.";
    header("Location: error.php?error=" . urlencode($errorMessage));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order ID: <?php echo htmlspecialchars($orderID); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/product_details.css">
    <script src="script/type-animations.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <div class="product">
            <h2>Order Details</h2>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order["orderID"]); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($order["status"]); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($order["datetime"]); ?></p>
            <p><strong>Total Price:</strong> $<?php echo htmlspecialchars(number_format($order["totalPrice"], 2)); ?>
            </p>
            <p><strong>Discount:</strong> $<?php echo htmlspecialchars(number_format($order["discount"], 2)); ?></p>
            <p><strong>Shipping:</strong> $<?php echo htmlspecialchars(number_format($order["shipping"], 2)); ?></p>
            <h3>Cart Items:</h3>
            <ul>
                <?php foreach ($order["cart"] as $item): ?>
                <li>Product ID: <?php echo htmlspecialchars($item["pid"]); ?>, Quantity:
                    <?php echo htmlspecialchars($item["qty"]); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>