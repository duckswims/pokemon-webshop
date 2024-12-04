<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Information</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
</head>

<body>
    <!-- Header -->
    <header>
        <!-- <iframe src="header.php" class="header-iframe"></iframe> -->
        <?php include ("header.php"); ?>
    </header>

    <main>
        <?php
            $sellerHeading = "Seller Information";
            $aboutHeading = "About Us";
            $aboutText = "Welcome to the greatest Pokémon store ever! Our mission is to bring you a unique and enjoyable experience
               as you explore our collection of Pokémon-themed merchandise.";
        ?>

        <h1><?php echo $sellerHeading; ?></h1>
        <section class="seller-info">
            <h2><?php echo $aboutHeading; ?></h2>
            <p><?php echo $aboutText; ?></p>

            <h3>Seller Details</h3>
            <p><strong>Company Name: </strong>PokéMart</p>
            <p><strong>Address: </strong>123 Pokémon Avenue, Kanto Region</p>
            <p><strong>Email: </strong><a href="mailto:contact@pokemart.com">contact@pokemart.com</a></p>
            <p><strong>Phone: </strong>+1 (123) 456-7890</p>

            <h3>Our Promise</h3>
            <p>We ensure top quality in every product we sell, with a focus on customer satisfaction and quick delivery
                times.
                Whether you're looking for Pokémon-themed items or exclusive collectibles, we're here to help you find
                what you love.</p>
        </section>
        <a href="index.php">Back to main page</a><br>
    </main>

    <!-- Footer -->
    <footer>
        <iframe src="footer.php" class="footer-iframe"></iframe>
    </footer>
</body>

</html>