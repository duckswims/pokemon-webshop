<?php
// Start the session to access session variables
session_start();

// == Define File Paths and Load Products ==

// Define paths
$productFile = 'json/product.json';
$defaultShoppingFile = 'users/shoppingCart.json';

// Load product data and create a product map
$products = json_decode(file_get_contents($productFile), true)["product"];
$productMap = array_column($products, null, 'pid');

// == Shopping Cart Handling ==

// Determine the shopping cart path
$shoppingFile = isset($_SESSION['username']) 
    ? 'users/' . $_SESSION['username'] . '/shoppingCart.json' 
    : $defaultShoppingFile;

// Read the shopping cart data
$cart = file_exists($shoppingFile) ? json_decode(file_get_contents($shoppingFile), true)['cart'] : [];

// == Handle AJAX Request for Payment ==
$input = json_decode(file_get_contents('php://input'), true);
if ($input['action'] === 'proceed_to_payment') {
    if (!isset($_SESSION['username'])) {
        echo json_encode(['success' => false, 'error' => 'User not logged in.']);
        exit;
    }

    // User-specific file paths
    $username = $_SESSION['username'];
    $userCartFile = "users/$username/shoppingCart.json";
    $orderHistoryFile = "users/$username/orderHistory.json";

    // Check if shopping cart exists
    if (!file_exists($userCartFile)) {
        echo json_encode(['success' => false, 'error' => 'Shopping cart not found.']);
        exit;
    }

    // Read and update cart data
    $cartData = json_decode(file_get_contents($userCartFile), true);
    $cartData['status'] = 'processing';
    $cartData['discount'] = $discount;
    $cartData['finalPrice'] = $finalPrice;
    $cartData['orderID'] = $username . '-' . bin2hex(random_bytes(5)); // 10 alphanumeric characters
    $cartData['datetime'] = date('Y-m-d H:i:s');
    
    // Append order to order history
    $orderHistory = file_exists($orderHistoryFile) 
        ? json_decode(file_get_contents($orderHistoryFile), true) 
        : [];
    $orderHistory[] = $cartData;
    file_put_contents($orderHistoryFile, json_encode($orderHistory, JSON_PRETTY_PRINT));

    // Clear shopping cart
    file_put_contents($userCartFile, json_encode(['cart' => []], JSON_PRETTY_PRINT));

    echo json_encode(['success' => true, 'message' => 'Order placed successfully!']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/shoppingCart.css">
    <script src="script/shoppingCart.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <?php if (empty($cart)): ?>
        <h1>Empty shopping cart :(</h1>
        <img src="https://media.printables.com/media/prints/599251/images/4771188_2e14b654-daa7-478c-8cc8-f5db25dce657_75ec0dd6-e0f7-4d1a-9c56-8a31dd407287/suprised-pikachu.png"
            alt="Pikachu" width="300px">
        <?php else: ?>
        <h1>Your Shopping Cart</h1>
        <div class="container">
            <div class="container product-container">
                <?php 
                // Loop through each item in the cart
                foreach ($cart as $item) {
                    // Get the product details using pid
                    $pid = $item['pid'];
                    if (isset($productMap[$pid])) {
                        $product = $productMap[$pid];
                        $name = $product['name'];
                        $img = $product['img_src'];
                        $price = $product['price'];
                        $qty = $item['qty'];

                        // Display the product details inside a box
                        echo "<div class='box' id='product-" . htmlspecialchars($pid) . "'>"; // Custom ID with pid
                        echo "<img src='" . htmlspecialchars($img) . "' class='pImg' alt='" . htmlspecialchars($name) . "'>";
                        echo "<div class='left'>";
                        echo "<span class='pid'>#" . htmlspecialchars($pid) . "</span>";
                        echo "<span class='pName'>" . htmlspecialchars($name) . "</span>";
                        echo "</div>"; // End left section

                        echo "<div class='right'>";
                        echo "<span class='price'>" . number_format(htmlspecialchars($price), 2) . "€ </span>";
                        echo "<input type='number' value='" . htmlspecialchars($qty) . "' name='qty[" . htmlspecialchars($pid) . "]' id='qty-" . htmlspecialchars($pid) . "' min='1' onchange='updateCartQty(\"" . htmlspecialchars($pid) . "\", this.value)' />";
                        echo "<button class='btn-red delete' id='delete-" . htmlspecialchars($pid) . "' onclick='removeFromCart(\"" . htmlspecialchars($pid) . "\")'>Remove</button>";
                        echo "</div>"; // End right section
                        echo "</div>"; // End box
                    }
                }
                ?>
            </div>

            <div class="container summary-container">
                <div class="container price-container">
                    Order Summary
                    <?php
                    // Initialize variables
                    $totalPrice = 0;

                    // Calculation of total price
                    foreach ($cart as $item) {
                        $product = $productMap[$pid];
                        $price = $product['price'];
                        $qty = $item['qty'];

                        $totalPrice += $price * $qty;
                    }

                    // Calculate tax (19% of totalPrice)
                    $tax = round($totalPrice * 0.19, 2);
                    $totalPriceWOtax = round($totalPrice - $tax, 2);
                    $totalPrice = round($totalPrice, 2);
                    $discount = 5;
                    $shipping = 4.99;
                    $finalPrice = $totalPrice - $discount + $shipping;
                    ?>
                    <div class="container">
                        <div class="left">
                            <strong>Total Price (without tax)</strong>
                        </div>
                        <div class="right">
                            <?php echo number_format($totalPriceWOtax, 2); ?>€
                        </div>
                    </div>
                    <div class="container">
                        <div class="left">
                            <strong>Tax (19%)</strong>
                        </div>
                        <div class="right">
                            <?php echo number_format($tax, 2); ?>€
                        </div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="left">
                            <strong>Subtotal</strong>
                        </div>
                        <div class="right">
                            <?php echo number_format($totalPrice, 2); ?>€
                        </div>
                    </div>
                    <?php if ($discount != 0): ?>
                    <div class="container">
                        <div class="left">
                            <strong>Discount</strong>
                        </div>
                        <div class="right">
                            <?php echo "- " . number_format($discount, 2); ?>€
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="left">
                            <strong>Shipping</strong>
                        </div>
                        <div class="right">
                            <?php echo number_format($shipping, 2); ?>€
                        </div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="left">
                            <strong>Total</strong>
                        </div>
                        <div class="right subtotal">
                            <span><?php echo number_format($finalPrice, 2); ?>€</span>
                        </div>
                    </div>
                    <button class="btn-blue payment">Proceed to Payment</button>
                </div>
                <div class="container discount-container">
                    Enter Discount Code
                    <input type="text">
                    <button>Redeem</button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>