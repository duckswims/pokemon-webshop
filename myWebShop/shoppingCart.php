<?php
// Start the session to manage user data
session_start();

// Define file paths for products, shopping cart, and order history
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$productFile = 'json/product.json';
$shoppingFile = isset($username) ? "users/$username/shoppingCart.json" : 'users/shoppingCart.json';
$orderHistoryFile = isset($username) ? "users/$username/orderHistory.json" : null;

// Load products from the product JSON file and create a product map for easy lookup
$products = json_decode(file_get_contents($productFile), true)['product'];
$productMap = array_column($products, null, 'pid');

// == Shopping Cart ==
// Read shopping cart data from the shopping cart file (if it exists)
$cart = [];
if (file_exists($shoppingFile)) {
    $fileData = json_decode(file_get_contents($shoppingFile), true);
    $cart = $fileData['cart'] ?? [];
}

// Handle GET request to retrieve the current cart count
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'getCartCount') {
    // Calculate the total number of items in the cart
    $cartCount = array_sum(array_column($cart, 'qty'));
    echo json_encode(['success' => true, 'cartCount' => $cartCount]);
    exit;
}

// == Price Calculation ==
// Calculate the total price of items in the cart (before and after tax)
$totalPrice = array_reduce($cart, function ($total, $item) use ($productMap) {
    $product = $productMap[$item['pid']] ?? null;
    return $product ? $total + $product['price'] * $item['qty'] : $total;
}, 0);

// Calculate tax (19% in this case) and the final price after applying discount and shipping cost
$tax = round($totalPrice * 0.19, 2);
$totalPriceWOtax = round($totalPrice - $tax, 2);
$finalPrice = round($totalPrice - 1 + 4.99, 2);  // Applying discount and shipping

// Handle AJAX requests for cart operations (update, remove, proceed to payment)
$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['action'])) {
    switch ($input['action']) {
        // Update the quantity of a product in the cart
        case 'update':
            if (isset($input['pid'], $input['qty'])) {
                $pid = $input['pid'];
                $qty = (int)$input['qty'];

                // Update the cart item with the new quantity
                foreach ($cart as &$item) {
                    if ($item['pid'] == $pid) {
                        $item['qty'] = $qty;
                        break;
                    }
                }

                // Save the updated cart to the shopping cart file
                file_put_contents($shoppingFile, json_encode(['cart' => $cart], JSON_PRETTY_PRINT));

                // Recalculate the total price after the update
                $totalPrice = array_reduce($cart, function ($total, $item) use ($productMap) {
                    $product = $productMap[$item['pid']] ?? null;
                    return $product ? $total + $product['price'] * $item['qty'] : $total;
                }, 0);

                // Return the updated total price as a response
                echo json_encode(['success' => true, 'totalPrice' => round($totalPrice, 2)]);
            }
            break;

        // Remove an item from the cart
        case 'remove':
            if (isset($input['pid'])) {
                $pid = $input['pid'];

                // Remove the item with the given product ID from the cart
                $cart = array_filter($cart, fn($item) => $item['pid'] !== $pid);
                file_put_contents($shoppingFile, json_encode(['cart' => array_values($cart)], JSON_PRETTY_PRINT));

                // Recalculate the total price after removal
                $totalPrice = array_reduce($cart, function ($total, $item) use ($productMap) {
                    $product = $productMap[$item['pid']] ?? null;
                    return $product ? $total + $product['price'] * $item['qty'] : $total;
                }, 0);

                // Return the updated total price as a response
                echo json_encode(['success' => true, 'totalPrice' => round($totalPrice, 2)]);
            }
            break;

        // Proceed to the payment process and place an order
        case 'proceed_to_payment':
            // Check if the user is logged in
            if (!$username) {
                echo json_encode(['success' => false, 'error' => 'User not logged in.']);
                exit;
            }

            // Check if the shopping cart exists
            if (!file_exists($shoppingFile)) {
                echo json_encode(['success' => false, 'error' => 'Shopping cart not found.']);
                exit;
            }

            // Update cart and order history data
            $cartData = json_decode(file_get_contents($shoppingFile), true);
            $cartData['status'] = 'processing';
            $cartData['shipping'] = 4.99;
            $cartData['discount'] = 1;
            $cartData['totalPrice'] = $totalPrice;
            $cartData['orderID'] = $username . '-' . bin2hex(random_bytes(5)); // Generate a unique order ID
            $cartData['datetime'] = date('Y-m-d H:i:s'); // Record the current date and time of the order

            // Append the current order to the user's order history
            $orderHistory = file_exists($orderHistoryFile) ? json_decode(file_get_contents($orderHistoryFile), true) : [];
            $orderHistory[] = $cartData;
            file_put_contents($orderHistoryFile, json_encode($orderHistory, JSON_PRETTY_PRINT));

            // Clear the shopping cart after order placement
            file_put_contents($shoppingFile, json_encode(['cart' => []], JSON_PRETTY_PRINT));

            // Return a success message with the order details
            echo json_encode(['success' => true, 'message' => 'Order placed successfully!']);
            break;

        // Handle invalid action
        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action or parameters.']);
            break;
    }
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
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <?php if (empty($cart)): ?>
        <h1>Empty shopping cart :( </h1>
        <img src="https://media.printables.com/media/prints/599251/images/4771188_2e14b654-daa7-478c-8cc8-f5db25dce657_75ec0dd6-e0f7-4d1a-9c56-8a31dd407287/suprised-pikachu.png"
            alt="Pikachu" width="300px"><br>
        <a href="all-products.php"><button>Back to Products</button></a>
        <?php else: ?>
        <h1>Your Shopping Cart</h1>
        <div class="container">
            <div class="container product-container">
                <?php 
                foreach ($cart as $item) {
                    $pid = $item['pid'];
                    if (isset($productMap[$pid])) {
                        $product = $productMap[$pid];
                        $name = $product['name'];
                        $img = $product['img_src'];
                        $price = $product['price'];
                        $qty = $item['qty'];

                        echo "<div class='box' id='product-" . htmlspecialchars($pid) . "'>";
                        echo "<img src='" . htmlspecialchars($img) . "' class='pImg' alt='" . htmlspecialchars($name) . "'>";
                        echo "<div class='left'>";
                        echo "<span class='pid'>#" . htmlspecialchars($pid) . "</span>";
                        echo "<span class='pName'>" . htmlspecialchars($name) . "</span>";
                        echo "</div>";
                        echo "<div class='right'>";
                        echo "<span class='price'>" . number_format(htmlspecialchars($price), 2) . "€ </span>";
                        echo "<input type='number' value='" . htmlspecialchars($qty) . "' name='qty[" . htmlspecialchars($pid) . "]' id='qty-" . htmlspecialchars($pid) . "' min='1' onchange='updateCartQty(\"" . htmlspecialchars($pid) . "\", this.value)' />";
                        echo "<button class='btn-red delete' id='delete-" . htmlspecialchars($pid) . "' onclick='removeFromCart(\"" . htmlspecialchars($pid) . "\")'>Remove</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                ?>
                <a href="all-products.php"><button>Back to Products</button></a>
            </div>

            <div class="container summary-container">
                <div class="container price-container">
                    Order Summary
                    <div class="container">
                        <div class="left"><strong>Total Price (without tax)</strong></div>
                        <div class="right"><?php echo number_format($totalPriceWOtax, 2); ?>€</div>
                    </div>
                    <div class="container">
                        <div class="left"><strong>Tax (19%)</strong></div>
                        <div class="right"><?php echo number_format($tax, 2); ?>€</div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="left"><strong>Subtotal</strong></div>
                        <div class="right"><?php echo number_format($totalPrice, 2); ?>€</div>
                    </div>
                    <?php if ($discount != 0): ?>
                    <div class="container">
                        <div class="left"><strong>Discount</strong></div>
                        <div class="right"><?php echo "- " . number_format($discount, 2); ?>€</div>
                    </div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="left"><strong>Shipping</strong></div>
                        <div class="right"><?php echo number_format($shipping, 2); ?>€</div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="left"><strong>Total</strong></div>
                        <div class="right subtotal"><span><?php echo number_format($finalPrice, 2); ?>€</span></div>
                    </div>
                    <button class="btn-blue payment" id="paymentBtn">Proceed to Payment</button>
                </div>

                <div class="container discount-container">
                    Enter Discount Code
                    <input type="text">
                    <button>Redeem Voucher</button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>