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
    <script src="script/extra-function2.js"></script>

</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <?php
            $welcomeMessage = "Welcome to Our Pokémon Store!";
            $shopDescription = "We offer a wide variety of Pokémon-themed products to suit your needs.";
        ?>
        <h1><?php echo $welcomeMessage; ?></h1>
        <p><?php echo $shopDescription; ?></p>

        <div>
            <button id="i-choose-you">I Choose You! <img src="img/pokeball.png" width="30px" alt="PokeBall"></button>
            <a href="all-products.php"><button>View All</button></a>
        </div>

    </main>


    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>