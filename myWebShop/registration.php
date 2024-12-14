<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $uName = $_POST['uName'];
    $password = $_POST['password'];

    $dirPath = "users/$uName";

    // Check if username already exists
    if (file_exists($dirPath)) {
        die('Username already exists. Please choose another.');
    }

    // Create user directory and files
    mkdir($dirPath, 0777, true);

    $info = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'username' => $uName,
        'password' => $password
    ];
    file_put_contents("$dirPath/info.json", json_encode($info, JSON_PRETTY_PRINT));

    // Initialize user-specific files
    $defaultShoppingFile = 'users/shoppingCart.json';
    if (file_exists($defaultShoppingFile)) {
        copy($defaultShoppingFile, "$dirPath/shoppingCart.json");
        file_put_contents($defaultShoppingFile, json_encode([], JSON_PRETTY_PRINT)); // Clear default shoppingCart
    }

    file_put_contents("$dirPath/orderHistory.json", json_encode([], JSON_PRETTY_PRINT));

    // Set session variables
    $_SESSION['username'] = $uName;
    $_SESSION['firstName'] = $firstName;
    $_SESSION['shoppingCart'] = json_decode(file_get_contents("$dirPath/shoppingCart.json"), true)['products'] ?? [];

    header("Location: customer.php");
    exit;
}

// Generate a random Pokémon image URL
$randomNumber = sprintf("%03d", rand(1, 1025));
$imageUrl = "https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/$randomNumber.png";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/forms.css">
    <script src="script/form-validation.js"></script>
    <script src="script/user-creation.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <main>
        <div class="container">
            <div class="box box-content box-blank">
                <h2>Welcome!</h2>
                <img src="<?= $imageUrl ?>" alt="Random Pokémon">
            </div>
            <div class="box box-content">
                <h2>Register</h2>
                <form action="" method="POST">
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                    <input type="text" id="uName" name="uName" placeholder="Username" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="password" id="repeatPassword" name="repeatPassword" placeholder="Confirm Password"
                        required>
                    <input type="submit" value="Register" class="btn btn-blue">
                </form>
                <?php if (!empty($errorMessage)): ?>
                <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
                <?php endif; ?>
                <p class="stretch">or</p>
                <p>Already a member? <a href="login.php">Login</a></p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>

    <script src="script/user-creation.js"></script>
</body>

</html>