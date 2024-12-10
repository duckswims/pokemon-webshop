<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in by checking if the username is set in the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $firstNameLive = $_SESSION['firstName'];
    $admin = $_SESSION['admin'];
} else {
    $username = null; // User is not logged in
}
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
                <?php if ($admin): ?>

                <a href="administrator.php" target="_parent">Administrator</a>
                <?php endif; ?>
            </div>
            <a href="shoppingCart.php" target="_parent">
                <div id="cart-container">
                    <img id="cart-icon" src="img/cart.png" alt="Shopping Cart" width="30px">
                    <span id="cart-count" style="display: none;">0</span>
                </div>
            </a>
            <button class="user-button">
                <img src="img/user.png" class="nav-img user-img">
            </button>
            <div class="user-dropdown">
                <?php if ($username): ?>
                <!-- User is logged in, show greeting and logout button -->
                <strong>Hello, <?php echo htmlspecialchars($firstName); ?>!</strong>
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

    <script src="script/style-modification.js"></script>
    <script src="script/user-button.js"></script>
</body>

</html>