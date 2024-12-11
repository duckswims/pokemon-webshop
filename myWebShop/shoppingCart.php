<?php
// Start the session
session_start();

// File Paths
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$productFile = 'json/product.json';
$defaultShoppingFile = 'users/shoppingCart.json';
$shoppingFile = $username ? "users/$username/shoppingCart.json" : $defaultShoppingFile;
$orderHistoryFile = $username ? "users/$username/orderHistory.json" : null;

// Load Products
$products = json_decode(file_get_contents($productFile), true)['product'];
$productMap = array_column($products, null, 'pid');

// Load Shopping Cart
$cart = file_exists($shoppingFile)
    ? (json_decode(file_get_contents($shoppingFile), true)['cart'] ?? [])
    : [];

// Initialize Pricing Variables
global $totalPrice, $discount, $shipping;
$totalPrice = 0;
$discount = 1;
$shipping = 4.99;

// Calculate Totals
foreach ($cart as $item) {
    $product = $productMap[$item['pid']];
    $totalPrice += $product['price'] * $item['qty'];
}

$tax = round($totalPrice * 0.19, 2);
$totalPriceWOtax = round($totalPrice - $tax, 2);
$totalPrice = round($totalPrice, 2);
$finalPrice = $totalPrice - $discount + $shipping;

// Handle GET request for cart count
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getCartCount') {
    $cartCount = array_sum(array_column($cart, 'qty'));
    echo json_encode(['success' => true, 'cartCount' => $cartCount]);
    exit;
}

// Handle AJAX Requests
$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['action'])) {
    $action = $input['action'];

    switch ($action) {
        case 'update':
            if (isset($input['pid'], $input['qty'])) {
                $pid = $input['pid'];
                $qty = (int)$input['qty'];

                foreach ($cart as &$item) {
                    if ($item['pid'] == $pid) {
                        $item['qty'] = $qty;
                        break;
                    }
                }

                file_put_contents($shoppingFile, json_encode(['cart' => $cart], JSON_PRETTY_PRINT));
                $totalPrice = calculateTotalPrice($cart, $productMap);
                echo json_encode(['success' => true, 'totalPrice' => round($totalPrice, 2)]);
            }
            break;

        case 'remove':
            if (isset($input['pid'])) {
                $pid = $input['pid'];
                $cart = array_filter($cart, fn($item) => $item['pid'] !== $pid);

                file_put_contents($shoppingFile, json_encode(['cart' => array_values($cart)], JSON_PRETTY_PRINT));
                $totalPrice = calculateTotalPrice($cart, $productMap);
                echo json_encode(['success' => true, 'totalPrice' => round($totalPrice, 2)]);
            }
            break;

        case 'proceed_to_payment':
            if (!$username) {
                echo json_encode(['success' => false, 'error' => 'User not logged in.']);
                exit;
            }

            if (!file_exists($shoppingFile)) {
                echo json_encode(['success' => false, 'error' => 'Shopping cart not found.']);
                exit;
            }

            $cartData = json_decode(file_get_contents($shoppingFile), true);
            $cartData['status'] = 'processing';
            $cartData['shipping'] = $shipping;
            $cartData['discount'] = $discount;
            $cartData['totalPrice'] = $totalPrice;
            $cartData['orderID'] = $username . '-' . bin2hex(random_bytes(5));
            $cartData['datetime'] = date('Y-m-d H:i:s');

            $orderHistory = file_exists($orderHistoryFile)
                ? json_decode(file_get_contents($orderHistoryFile), true)
                : [];
            $orderHistory[] = $cartData;
            file_put_contents($orderHistoryFile, json_encode($orderHistory, JSON_PRETTY_PRINT));

            file_put_contents($shoppingFile, json_encode(['cart' => []], JSON_PRETTY_PRINT));

            echo json_encode(['success' => true, 'message' => 'Order placed successfully!']);
            break;

        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action or parameters.']);
            break;
    }
    exit;
}

// Helper Function to Calculate Total Price
function calculateTotalPrice($cart, $productMap) {
    $totalPrice = 0;
    foreach ($cart as $item) {
        $product = $productMap[$item['pid']];
        $totalPrice += $product['price'] * $item['qty'];
    }
    return $totalPrice;
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
            alt="Pikachu" width="300px">
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
                        echo "<img class='btn-delete' id='delete-" . htmlspecialchars($pid) . "' src='img/delete.png' alt='Delete' onclick='removeFromCart(\"" . htmlspecialchars($pid) . "\")' />";
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