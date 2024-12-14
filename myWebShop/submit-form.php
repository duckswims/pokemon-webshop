<?php
// Start the session to access session variables
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect to the error page if accessed directly
    header("Location: error.php?error=Form not submitted properly.");
    exit();
}

// Collect and sanitize the form data
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$username = isset($_POST['emailusername']) ? htmlspecialchars($_POST['emailusername']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

// Validate the form data
if (empty($name) || empty($email) || empty($message) || empty($username)) {
    // Redirect to the error page with an error message
    header("Location: error.php?error=All fields are required.");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/information.css">
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <main>
        <h2 class="section-title">Thank you, <?= $name ?>!</h2>
        <p class="section-text">
            Your message has been received. We will get back to you shortly.
        </p>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>