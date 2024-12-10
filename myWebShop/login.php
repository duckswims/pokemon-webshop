<?php
// Start session to manage login state
session_start();

$errorMessage = ''; // Initialize an error message variable

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['uName'];
    $password = $_POST['password'];

    // Define the path to the JSON file
    $jsonFile = "users/$username/info.json";
    $shoppingFile = "users/$username/shoppingCart.json";

    // Check if the user exists
    if (file_exists($jsonFile)) {
        // Read the JSON file
        $userData = json_decode(file_get_contents($jsonFile), true);
        $shoppingData = json_decode(file_get_contents($shoppingFile), true);

        // Check if the password matches
        if ($userData['password'] === $password) {
            // Set session variables for the logged-in user
            $_SESSION['username'] = $username;
            $_SESSION['firstName'] = $userData['firstName'] ?? 'N/A';
            $_SESSION['admin'] = $userData['admin'] ?? null;
            $_SESSION['shoppingCart'] = $shoppingData['products'] ?? null;

            // Redirect to the customer page
            header("Location: customer.php");
            exit;
        } else {
            $errorMessage = 'Password does not match.';
        }
    } else {
        $errorMessage = 'User does not exist.';
    }
    
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
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/forms.css">
    <script src="script/form-validation.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <main>
        <div class="container">
            <div class="box box-content box-blank">
                <h2>Welcome back!</h2>
                <img src="<?php echo $imageUrl; ?>" alt="Random Pokémon">
            </div>
            <div class="box box-content">
                <h2>Login</h2>
                <form action="login.php" method="POST">
                    <input type="text" name="uName" id="uName" placeholder="Username" required>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <input type="submit" value="Login" class="btn btn-blue">
                </form>
                <br>
                <?php if (!empty($errorMessage)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
                <?php endif; ?>
                <p class="stretch">or</p>
                <p>Not a member? <a href="registration.php">Sign Up</a></p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>