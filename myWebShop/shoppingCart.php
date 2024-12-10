<?php
// Start the session to access session variables
session_start();

// == Products ==

// Define the product file
$productFile = 'json/product.json';
$products = json_decode(file_get_contents($productFile), true)["product"];

// Create a mapping of pid to product details (name and price)
$productMap = [];
foreach ($products as $product) {
    $productMap[$product['pid']] = $product;
}



// == Shopping Cart ==

// Define the default shopping cart path
$defaultShoppingFile = 'users/shoppingCart.json';

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Path to the logged-in user's shopping cart
    $shoppingFile = 'users/' . $_SESSION['username'] . '/shoppingCart.json';
} else {
    // Use the default shopping cart file
    $shoppingFile = $defaultShoppingFile;
}

// Read the shopping cart data from the JSON file
if (file_exists($shoppingFile)) {
    $fileData = json_decode(file_get_contents($shoppingFile), true);
    $cart = isset($fileData['cart']) ? $fileData['cart'] : [];
} else {
    $cart = [];
}


// Handle the AJAX request
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['action'])) {
    $action = $input['action'];

    if ($action === 'update' && isset($input['pid'], $input['qty'])) {
        $pid = $input['pid'];
        $qty = (int)$input['qty'];

        // Update the quantity in the cart
        foreach ($cart as &$item) {
            if ($item['pid'] == $pid) {
                $item['qty'] = $qty;
                break;
            }
        }

        // Save the updated cart back to the JSON file
        file_put_contents($shoppingFile, json_encode(['cart' => $cart], JSON_PRETTY_PRINT));
    } elseif ($action === 'remove' && isset($input['pid'])) {
        $pid = $input['pid'];

        // Remove the item from the cart
        $cart = array_filter($cart, function ($item) use ($pid) {
            return $item['pid'] !== $pid;
        });

        // Save the updated cart back to the JSON file
        file_put_contents($shoppingFile, json_encode(['cart' => array_values($cart)], JSON_PRETTY_PRINT));
    }
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

            <div class="container price-container">
                Summary<br>
                <div>
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

                    // Calculate totalPrice without tax
                    $totalPriceWOtax = round($totalPrice - $tax, 2);

                    // Round totalPrice to 2 decimal points
                    $totalPrice = round($totalPrice, 2);
                    ?>


                    <div class="container">
                        <div class="left">
                            <strong>Total Price (without tax):</strong>
                        </div>
                        <div class="right">
                            <?php echo number_format($totalPriceWOtax, 2); ?>€
                        </div>
                    </div>
                    <div class="container">
                        <div class="left">
                            <strong>Tax (19%):</strong>
                        </div>
                        <div class="right">
                            <?php echo number_format($tax, 2); ?>€
                        </div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="left">
                            <strong>Total Price:</strong>
                        </div>
                        <div class="right">
                            <?php echo number_format($totalPrice, 2); ?>€
                        </div>
                    </div>
                </div>
                <button class="btn-blue">Proceed to Payment</button>
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