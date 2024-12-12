<?php
// Start the session to access session variables
session_start();

// == Cart Number ==============

// Determine the file path for the shopping cart
$shoppingPath = 'users/shoppingCart.json';  // Default
if ($username) {
    $shoppingPath = 'users/' . $username . '/shoppingCart.json';
}

// Load the cart data if the file exists
$fileData = json_decode(file_get_contents($shoppingPath), true);
$cart = $fileData['cart'];

// Count number of items in cart
$cartCount = 0;
foreach ($cart as $item) {
    $cartCount += $item['qty'];
}

// Cast to session
$_SESSION['counter'] = $cartCount;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/header.css">
    <script src="script/style-modification.js"></script>
    <script src="script/user-button.js"></script>
    <script src="script/cart-update.js"></script>
</head>

<body>
    <header>
        <div class="left">
            <a href="index.php" target="_parent">
                <div class="logo-container">
                    <img src="img/shop-logo.png" class="logo" alt="PokéMart">
                </div>
            </a>
        </div>
        <div class="right">
            <div class="nav-links">
                <a href="about.php" target="_parent">About Us</a>
                <a href="price-calculator.php" target="_parent">Price Calculator</a>
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                <a href="admin-orders.php" target="_parent">Orders</a>
                <a href="admin-users.php" target="_parent">User Control</a>
                <?php endif; ?>

            </div>
            <a href="shoppingCart.php" target="_parent">
                <div id="cart-container">
                    <img id="cart-icon" src="img/cart.png" alt="Shopping Cart" width="30px">
                    <span id="cart-count" style="display: none;"><?php echo $_SESSION['counter']; ?></span>
                </div>
            </a>
            <button class="user-button">
                <img src="img/user.png" class="nav-img user-img">
            </button>
            <div class="user-dropdown">
                <?php if (isset($_SESSION['username']) && $_SESSION['username']): ?>
                <strong>Hello, <?php echo htmlspecialchars($_SESSION['firstName']); ?>!</strong>

                <a href="customer.php" target="_parent"><button class="btn-blue">Profile</button></a>
                <a href="orderHistory.php" target="_parent"><button class="btn-blue">Order History</button></a>
                <a href="logout.php" target="_parent"><button class="btn-blue">Logout</button></a>
                <?php else: ?>
                <!-- User is not logged in, show login and register buttons -->
                <a href="login.php" target="_parent"><button class="btn-blue">Login</button></a>
                <a href="registration.php" target="_parent"><button class="btn-blue">Register</button></a>
                <?php endif; ?>
            </div>
            <button class="mode-button">
                <img src="img/mode/light.png" class="nav-img mode-img">
            </button>
            <button class="hamburger-btn hamburger-menu">
                <img src="img/hamburger.png" alt="Menu" class="hamburger-icon">
            </button>
        </div>
    </header>
</body>

</html>