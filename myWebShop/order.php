<?php
// Start the session to access session variables
session_start();

// Initialize error message
$errorMessage = "";

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    $errorMessage = "Access denied. Please log in.";
    header("Location: error.php?error=" . urlencode($errorMessage));
    exit;
}

// Get the username and admin status from the session
$username = $_SESSION["username"];
$isAdmin = isset($_SESSION["admin"]) && $_SESSION["admin"] === true;

// Get the orderID from the query string
$orderID = isset($_GET["orderID"]) ? htmlspecialchars($_GET["orderID"]) : null;
if (!$orderID) {
    $errorMessage = "Order ID is missing.";
    header("Location: error.php?error=" . urlencode($errorMessage));
    exit;
}

// Determine the username from the orderID if the user is an admin
if ($isAdmin) {
    $lastDashPos = strrpos($orderID, '-');
    if ($lastDashPos !== false) {
        $username = substr($orderID, 0, $lastDashPos); // Extract everything before the last '-'
    } else {
        $errorMessage = "Invalid order ID format.";
        header("Location: error.php?error=" . urlencode($errorMessage));
        exit;
    }
}

// Path to the user's order history and product data JSON files
$orderHistoryPath = "users/$username/orderHistory.json";
$productDataPath = "json/product.json";

// Check if the order history file exists
if (!file_exists($orderHistoryPath)) {
    $errorMessage = "Error: Order history not found for user $username.";
    header("Location: error.php?error=" . urlencode($errorMessage));
    exit;
}

// Decode the JSON files
$productData = json_decode(file_get_contents($productDataPath), true);
$orderHistory = json_decode(file_get_contents($orderHistoryPath), true);
if ($orderHistory === null) {
    $errorMessage = "Error: Unable to parse order history.";
    header("Location: error.php?error=" . urlencode($errorMessage));
    exit;
}

// Create a lookup array for product images
$productImages = [];
foreach ($productData["product"] as $product) {
    $productImages[$product["pid"]] = $product["img_src"];
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
    <link rel="stylesheet" href="styles/order-display.css">
    <link rel="stylesheet" href="styles/order-status.css">
    <script src="script/type-animations.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main Content -->
    <main>
        <h2>Order ID: <?php echo htmlspecialchars($order["orderID"]); ?></h2>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($order["datetime"]); ?></p>
        <strong class="<?php echo strtolower($order["status"]) === "completed" 
            ? 'status-completed' 
            : (in_array(strtolower($order["status"]), ['cancelled', 'returned']) 
            ? 'status-cancelled-returned' : ''); ?>">
            <strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($order["status"])); ?>
        </strong>

        <?php if (strtolower($order["status"]) === "cancelled" && isset($order["cancelledReason"])): ?>
        <p class="cancelled-message" style="color: red;">
            <?php echo strpos($order["cancelledReason"], $username) === 0 
                ? "You have cancelled this order." 
                : htmlspecialchars($order["cancelledReason"]); ?>
        </p>
        <?php endif; ?>

        <p><strong>Total Price:</strong> <?php echo htmlspecialchars(number_format($order["totalPrice"], 2)); ?> &euro;
        </p>

        <h3>Products</h3>
        <div class="container" style="display: flex; flex-wrap: wrap;">
            <?php foreach ($order["cart"] as $item): ?>
            <?php if (isset($productImages[$item["pid"]])): ?>
            <div class="order-product-item box" style="flex-direction: column; align-items: center; min-width: 200px;">
                <img src="<?php echo htmlspecialchars($productImages[$item["pid"]]); ?>" alt="Product Image"
                    style="width: 80px;" />
                <p>Quantity: <?php echo htmlspecialchars($item["qty"]); ?></p>
                <a href="product.php?pid=<?php echo htmlspecialchars($item["pid"]); ?>">
                    <button>View Product</button>
                </a>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <br>
        <?php if ($isAdmin): ?>
        <a href="admin-orders.php"><button>Back to Order Control</button></a>
        <?php else: ?>
        <a href="orderHistory.php"><button>Back to Order History</button></a>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>