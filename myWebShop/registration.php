<?php
// Start the session to track the user
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $uName = $_POST['uName'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    // Check if username already exists
    $dirPath = 'users/' . $uName;
    if (file_exists($dirPath)) {
        $errorMessage = 'Username already exists. Please choose another.';
    }

    // Create a folder named after the username
    if (!file_exists($dirPath)) {
        mkdir($dirPath, 0777, true);
    }

    // Create info.json with username and password
    $info = array(
        'firstName' => $firstName, 
        'lastName' => $lastName,
        'username' => $uName, 
        'password' => $password,
    );
    file_put_contents($dirPath . '/info.json', json_encode($info, JSON_PRETTY_PRINT));

    // Create empty shoppingCart.json
    $defaultShoppingFile = "users/shoppingCart.json";
    $defaultContent = file_get_contents($defaultShoppingFile);
    file_put_contents($dirPath . '/shoppingCart.json', $defaultContent);        // put default shoppingCart into user shoppingCart
    file_put_contents($defaultShoppingFile, json_encode([], JSON_PRETTY_PRINT)); // clear default shoppingCart

    // Create empty orderHistory.json
    file_put_contents($dirPath . '/orderHistory.json', json_encode([], JSON_PRETTY_PRINT));

    // Store the username in the session
    $_SESSION['username'] = $uName;
    $_SESSION['firstName'] = $firstName;

    // Store shopping cart in session
    $shoppingFile = "users/$username/shoppingCart.json";
    $shoppingData = json_decode(file_get_contents($shoppingFile), true);
    $_SESSION['shoppingCart'] = $shoppingData['products'] ?? null;

    // Redirect to a success page or login page after successful registration
    header("Location: customer.php");
    exit;
}
?>
<?php
// Generate a random number between 1 and 1025
$randomNumber = rand(1, 1025);

// Format the number to always be 3 digits (e.g., 001, 010, 100, etc.)
$formattedNumber = sprintf("%03d", $randomNumber);

// Construct the image URL using the formatted number
$imageUrl = "https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/$formattedNumber.png";
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
        <?php include ("header.php"); ?>
    </header>

    <main>
        <div class="container">
            <div class="box box-content box-blank">
                <h2>Welcome!</h2>
                <img src="<?php echo $imageUrl; ?>" alt="Random Pokémon">
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
                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
                <?php endif; ?>
                <p class="stretch">or</p>
                <p>Already a member? <a href="login.php">Login</a></p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>

    <script src="script/user-creation.js"></script>
</body>

</html>