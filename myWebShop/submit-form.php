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
    <title>Pokémon Store</title>
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
        <?php include ("header.php"); ?>
    </header>

    <main>
        <!-- <h2 class="section-title">Contact Us</h2>
        <p class="section-text">
            We’d love to hear from you! If you have any questions, comments, or feedback, feel free to reach out to us
            using the form below.
        </p> -->

        <?php
        // Check if the form was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect and sanitize the form data
            $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
            $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
            $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

            // Validate the form data
            if (!empty($name) && !empty($email) && !empty($message)) {
                echo '
                <h2 class="section-title">Thank you, '. $name .'!</h2>
                <p class="section-text">
                    Your message has been received. We will get back to you shortly.
                </p>
                ';
            } else {
                echo "<h3>Error: All fields are required!</h3>";
            }
        } else {
            // Redirect if accessed directly without submitting the form
            header("Location: index.php");
            exit();
        }
        ?>
    </main>


    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>