<?php
// Start the session to manage user data
session_start();

// Define file paths for products, shopping cart, and order history
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$isBlocked = isset($_SESSION["blocked"]) && $_SESSION["blocked"] === true;
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

// Check if the user is logged in and has an order history
if ($username && file_exists($orderHistoryFile)) {
    $orderHistory = json_decode(file_get_contents($orderHistoryFile), true);
    $orderCount = count($orderHistory);

    // Apply discount based on order count
    if (($orderCount + 1) % 20 === 0) {
        $orderDiscount = 0.20;  // 20% discount
        $orderDiscountMsg = "20% off (" . ($orderCount + 1) . " order)";
    } elseif (($orderCount + 1) % 10 === 0) {
        $orderDiscount = 0.10;  // 10% discount
        $orderDiscountMsg = "10% off (" . ($orderCount + 1) . " order)";
    } else {
        $orderDiscount = 0;  // No discount
    }
} else {
    $orderDiscount = 0;  // No discount if user is not logged in or has no order history
}




// Helper Function to Calculate Price
function calculatePrices($cart, $productMap, $orderDiscount)
{
    global $totalPriceWOtax, $tax, $totalPrice, $shipping, $orderDisc, $couponDisc, $finalPrice;

    // Calculate total price before tax
    $totalPrice = array_reduce($cart, function ($total, $item) use ($productMap) {
        $product = $productMap[$item['pid']] ?? null;
        return $product ? $total + $product['price'] * $item['qty'] : $total;
    }, 0);

    // Set shipping cost based on total price
    $shipping = ($totalPrice >= 1000) ? 0 : 9.99;

    // Calculate tax (19%) and the final price after applying discount and shipping cost
    $tax = round($totalPrice * 0.19, 2);
    $totalPriceWOtax = round($totalPrice - $tax, 2);
    $orderDisc = $totalPrice * $orderDiscount;
    $finalPrice = round($totalPrice - $orderDisc - $couponDisc + $shipping, 2);

    
    return [
        'totalPriceWOtax' => $totalPriceWOtax,
        'tax' => $tax,
        'totalPrice' => $totalPrice,
        'shipping' => $shipping,
        'orderDisc' => $orderDisc,
        'couponDisc' => $couponDisc,
        'finalPrice' => $finalPrice
    ];
}

$prices = calculatePrices($cart, $productMap, $orderDiscount);

// Handle AJAX requests for cart operations (update, remove, proceed to payment)
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['action'])) {
    switch ($input['action']) {
        case 'update':
            // Update cart quantity
            $pid = $input['pid'];
            $qty = (int)$input['qty'];

            // Update the cart item with the new quantity
            foreach ($cart as &$item) {
                if ($item['pid'] == $pid) {
                    $item['qty'] = $qty;
                    break;
                }
            }

            // Save updated cart to the file
            file_put_contents($shoppingFile, json_encode(['cart' => $cart], JSON_PRETTY_PRINT));

            // Recalculate the prices and return updated price data
            $prices = calculatePrices($cart, $productMap, $orderDiscount);
            echo json_encode([
                'success' => true,
                'totalPriceWOtax' => $prices['totalPriceWOtax'],
                'tax' => $prices['tax'],
                'totalPrice' => $prices['totalPrice'],
                'shipping' => $prices['shipping'],
                'orderDisc' => $prices['orderDisc'],
                'couponDisc' => $prices['couponDisc'],
                'finalPrice' => $prices['finalPrice']
            ]);
            break;

        case 'remove':
            // Remove item from cart
            $pid = $input['pid'];
            $cart = array_filter($cart, fn($item) => $item['pid'] !== $pid);
            file_put_contents($shoppingFile, json_encode(['cart' => array_values($cart)], JSON_PRETTY_PRINT));

            // Recalculate the prices and return updated price data
            $prices = calculatePrices($cart, $productMap, $orderDiscount);
            echo json_encode([
                'success' => true,
                'totalPriceWOtax' => $prices['totalPriceWOtax'],
                'tax' => $prices['tax'],
                'totalPrice' => $prices['totalPrice'],
                'shipping' => $prices['shipping'],
                'orderDisc' => $prices['orderDisc'],
                'couponDisc' => $prices['couponDisc'],
                'finalPrice' => $prices['finalPrice']
            ]);
            break;

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
            $cartData['status'] = 'confirmed';
            $cartData['shipping'] = $shipping;
            $cartData['shipping'] = $shipping;
            $cartData['orderDisc'] = $orderDisc;
            $cartData['couponDisc'] = $couponDisc;
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

// Fetch coupon data from the JSON file
function getCoupons() {
    $jsonFile = 'json/coupon.json';

    if (!file_exists($jsonFile)) {
        return [];
    }

    $jsonData = file_get_contents($jsonFile);
    return json_decode($jsonData, true)['coupons'];
}

// Validate the coupon code
function validateCoupon($code) {
    $coupons = getCoupons();

    foreach ($coupons as $coupon) {
        if ($coupon['code'] === strtoupper(trim($code))) {
            return $coupon;
        }
    }

    return null;
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_code'])) {
    $couponCode = $_POST['coupon_code'];
    $coupon = validateCoupon($couponCode);

    if ($coupon) {
        if ($coupon['valid']) {
            echo json_encode([
                'status' => 'success',
                'message' => "Valid coupon: {$coupon['description']}.",
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "The coupon '{$couponCode}' is invalid.",
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => "The coupon '{$couponCode}' does not exist.",
        ]);
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
    <script src="script/coupon.js"></script>
</head>

<body>
    <header><?php include("header.php"); ?></header>

    <main>
        <h1>Your Shopping Cart</h1>
        <div class="container">
            <div class="container product-container">
                <?php if (empty($cart)): ?>
                <div class="container" style="flex-direction: column; align-items: center">
                    <img src="https://media.printables.com/media/prints/599251/images/4771188_2e14b654-daa7-478c-8cc8-f5db25dce657_75ec0dd6-e0f7-4d1a-9c56-8a31dd407287/suprised-pikachu.png"
                        alt="Pikachu" width="300px">
                    <strong>So empty...</strong>
                </div>
                <?php else: ?>
                <?php 
                    foreach ($cart as $item) {
                        $pid = $item['pid'];
                        if (isset($productMap[$pid])) {
                            $product = $productMap[$pid];
                            $name = $product['name'];
                            $img = $product['img_src'];
                            $price = $product['price'];
                            $qty = $item['qty'];
                    ?>
                <div class="box" id="product-<?php echo htmlspecialchars($pid); ?>">
                    <img src="<?php echo htmlspecialchars($img); ?>" class="pImg"
                        alt="<?php echo htmlspecialchars($name); ?>">
                    <div class="left">
                        <span class="pid">#<?php echo htmlspecialchars($pid); ?></span>
                        <span class="pName"><?php echo htmlspecialchars($name); ?></span>
                    </div>
                    <div class="right">
                        <span class="price"><?php echo number_format(htmlspecialchars($price), 2); ?>€ </span>
                        <input type="number" value="<?php echo htmlspecialchars($qty); ?>"
                            name="qty[<?php echo htmlspecialchars($pid); ?>]"
                            id="qty-<?php echo htmlspecialchars($pid); ?>" min="1"
                            onchange="updateCartQty('<?php echo htmlspecialchars($pid); ?>', this.value)" />
                        <img class="btn-delete" id="delete-<?php echo htmlspecialchars($pid); ?>" src="img/delete.png"
                            alt="Delete" onclick="removeFromCart('<?php echo htmlspecialchars($pid); ?>')" />
                    </div>
                </div>
                <?php 
                        }
                    }
                    ?>
                <?php endif; ?>
                <a href="all-products.php"><button>Back to Products</button></a>
            </div>

            <div class="container summary-container">
                <div class="container price-container">
                    Order Summary
                    <div class="container">
                        <div class="left"><strong>Total Price (without tax)</strong></div>
                        <div class="right" id="totalPriceWOtax"><?php echo number_format($totalPriceWOtax, 2); ?>€</div>
                    </div>
                    <div class="container">
                        <div class="left"><strong>Tax (19%)</strong></div>
                        <div class="right" id="tax"><?php echo number_format($tax, 2); ?>€</div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="left"><strong>Subtotal</strong></div>
                        <div class="right" id="subtotal"><?php echo number_format($totalPrice, 2); ?>€</div>
                    </div>
                    <?php if ($orderDisc > 0): ?>
                    <div class="container" id="discount-container">
                        <div class="left">
                            <strong>Discount</strong>
                            <p style="font-size: 0.8em; color: grey;">
                                <?php echo htmlspecialchars($orderDiscountMsg); ?>
                            </p>
                        </div>
                        <div class="right" id="orderDisc"><?php echo "- " . number_format($orderDisc, 2); ?>€</div>
                    </div>
                    <?php endif; ?>
                    <div class="container">
                        <div class="left">
                            <strong>Shipping</strong>
                            <p id="shippingMessage" style="font-size: 0.8em; color: grey;">Free shipping after 1000€</p>
                        </div>
                        <div class="right" id="shipping"><?php echo number_format($shipping, 2); ?>€</div>
                    </div>
                    <hr>
                    <div class="container" style="align-items: center;">
                        <div class="left"><strong>Total</strong></div>
                        <div class="right subtotal" id="finalPrice"><?php echo number_format($finalPrice, 2); ?>€</div>
                    </div>
                    <?php if (!$isBlocked): ?>
                    <button class="btn-blue payment" id="paymentBtn">Proceed to Payment</button>
                    <?php else: ?>
                    <button class="btn-red" disabled>Your account is blocked by the administrator</button>
                    <?php endif; ?>
                </div>

                <div class="container discount-container">
                    <label for="coupon_code">Enter Discount Code</label>
                    <input type="text" id="coupon_code">
                    <button onclick="redeemVoucher()">Redeem Voucher</button>
                    <p id="message"></p>
                </div>
            </div>
    </main>

    <!-- Footer -->
    <footer><?php include("footer.php"); ?></footer>
</body>

</html>