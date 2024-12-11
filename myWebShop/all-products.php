<?php
// Start the session to manage user data
session_start();

// Retrieve the username from the session, if available
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// == Adding item to the cart ====================================
// Check if the request method is POST (i.e., adding an item to the cart)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the incoming JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Ensure the necessary data (pid and quantity) are provided
    if (!isset($data['pid'], $data['quantity'])) {
        // Return an error response if the data is invalid
        echo json_encode(['success' => false, 'error' => 'Invalid data provided']);
        exit;
    }

    // Sanitize and retrieve the product ID (pid) and quantity
    $pid = htmlspecialchars($data['pid']);
    $quantity = intval($data['quantity']);

    // Determine the file path for the shopping cart based on whether the user is logged in
    $shoppingPath = $username ? "users/$username/shoppingCart.json" : "users/shoppingCart.json";

    // Ensure the directory for the cart file exists
    $directory = dirname($shoppingPath);
    if (!is_dir($directory)) {
        // Create the directory if it doesn't exist
        mkdir($directory, 0777, true);
    }

    // Initialize the cart as an empty array if the cart file doesn't exist
    $cart = [];
    if (file_exists($shoppingPath)) {
        // Load the existing cart data from the JSON file
        $fileData = json_decode(file_get_contents($shoppingPath), true);
        // Retrieve the cart items from the file or initialize an empty array if not set
        $cart = $fileData['cart'] ?? [];
    }

    // Check if the product already exists in the cart
    $found = false;
    foreach ($cart as &$item) {
        if ($item['pid'] === $pid) {
            // If the product is already in the cart, update its quantity
            $item['qty'] += $quantity;
            $found = true;
            break;
        }
    }

    // If the product is not found in the cart, add it as a new item
    if (!$found) {
        $cart[] = ['pid' => $pid, 'qty' => $quantity];
    }

    // Update the cart in the file with the modified cart data
    $fileData['cart'] = $cart;
    file_put_contents($shoppingPath, json_encode($fileData, JSON_PRETTY_PRINT));

    // Calculate the total number of items in the cart and update the session
    $cartCount = array_sum(array_column($cart, 'qty'));
    $_SESSION['counter'] = $cartCount;

    // Respond with a success message and the updated cart count
    echo json_encode(['success' => true, 'cartCount' => $cartCount]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/product_display.css">
    <script src="script/collection-list.js"></script>
    <script src="script/cart-update.js"></script>
    <script src="script/search-filter.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <main>
        <h1>Pokémon List</h1>
        <p>
            This is a Pokédex webpage designed to provide detailed information about various Pokémon, categorized by
            type and category.
        </p>
        <br>
        <div class="search-bar">
            <input type="text" id="search-field" placeholder="Search by PID or Name..." onkeyup="filterProducts()">
        </div>
        <br>

        <div class="product-display" id="product-display">
            <?php
            // Load the JSON file
            $jsonString = file_get_contents('json/product.json');
            $data = json_decode($jsonString, true);

            // Check if the JSON contains the 'product' key
            if (isset($data['product'])) {
                foreach ($data['product'] as $product) {
                    echo '
                    <div class="box product-box" data-pid="' . htmlspecialchars($product['pid']) . '" data-name="' . htmlspecialchars(strtolower($product['name'])) . '">
                        <div class="left">
                            <div class="box-content box-blank">
                                <img src="' . htmlspecialchars($product['img_src']) . '" width="100px">
                                <a href="product.php?pid=' . htmlspecialchars($product['pid']) . '">
                                    <button>View</button>
                                </a>
                            </div>
                        </div>
                        <div class="right">
                            <h3 class="title">' . ' #' . htmlspecialchars($product['pid']) . " " . htmlspecialchars($product['name']) . '</h3>
                            <p class="desc">' . htmlspecialchars($product['desc']) . '</p>
                            <p class="price"><strong>Price: </strong>' . htmlspecialchars($product['price']) . '€</p>
                            <div class="add-div">
                                <input type="number" class="qty-input" id="quantity" value="1" min="1">
                                <button class="btn-blue add-cart" data-pid="' . htmlspecialchars($product['pid']) . '">Add to cart</button>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '
                <h2 style="color: red;">Error 404: Product information not found :( </h2>
                ';
            }
            ?>
        </div>

    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>