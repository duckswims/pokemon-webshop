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
        <h2 class="section-title">About Us</h2>
        <p class="section-text">
            Welcome to the greatest Pokémon store ever! Our mission is to bring you a unique and enjoyable
            experience as you explore our collection of Pokémon-themed merchandise.
        </p>

        <h3 class="subheading">Our Details</h3>
        <ul class="seller-details">
            <li><strong>Company Name:</strong> PokéMart</li>
            <li><strong>Address:</strong> 123 Pokémon Avenue, Kanto Region</li>
            <li><strong>Email:</strong> <a href="mailto:contact@pokemart.com">contact@pokemart.com</a></li>
            <li><strong>Phone:</strong> +1 (123) 456-7890</li>
        </ul>

        <h3 class="subheading">Our Promise</h3>
        <p class="section-text">
            We ensure top quality in every product we sell, with a focus on customer satisfaction and quick
            delivery times.
            Whether you're looking for Pokémon-themed items or exclusive collectibles, we're here to help you
            find what you love.
        </p>

        <a href="contact-form.php" class="contact-btn">Contact Us</a>
    </main>


    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>