<?php
// Start the session to access session variables
session_start();
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
        <h2 class="section-title">Contact Us</h2>
        <p class="section-text">
            We’d love to hear from you! If you have any questions, comments, or feedback, feel free to reach out to us
            using the form below.
        </p>

        <!-- Contact Form -->
        <form action="submit-form.php" method="POST" class="contact-form">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required placeholder="Your full name">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="Your username">

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required placeholder="Your email address">

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required placeholder="Subject of your message">

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required placeholder="Your message"></textarea>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </main>


    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>