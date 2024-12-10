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

// Destroy all session variables
session_unset();
session_destroy();
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
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <main>
        <h1>Logout Successful</h1>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>