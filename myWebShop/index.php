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

        <button id="i-choose-you">I Choose You! <img src="img/pokeball.png" width="30px" alt="PokeBall"></button>

        <h2><a href="allProducts.php">All Products</a></h2>
        <ul class="menu">

            <li><a href="categoryList/types/typeList.php">Types:</span>
                    <ul class="submenu">
                        <li>
                            <a href="categoryList/types/grass.php">
                                Grass <img src="https://www.serebii.net/pokedex-sv/type/icon/grass.png" width="20px"
                                    alt="Grass Icon" class="type-icon">
                            </a>
                        </li>
                        <li>
                            <a href="categoryList/types/poison.php">
                                Poison <img src="https://www.serebii.net/pokedex-sv/type/icon/poison.png" width="20px"
                                    alt="Poison Icon" class="type-icon">
                            </a>
                        </li>
                        <li>
                            <a href="categoryList/types/water.php">
                                Water <img src="https://www.serebii.net/pokedex-sv/type/icon/water.png" width="20px"
                                    alt="Water Icon" class="type-icon">
                            </a>
                        </li>
                    </ul>
            </li>


            <li><a href="categoryList/categories/categoryList.php">Category:</span>
                    <ul class="submenu">
                        <li><a href="categoryList/categories/seed.php">Seed</a></li>
                        <li><a href="categoryList/categories/tiny-turtle.php">Tiny-turtle</a></li>
                        <li><a href="categoryList/categories/turtle.php">Turtle</a></li>
                        <li><a href="categoryList/categories/shellfish.php">Shellfish</a></li>
                    </ul>
            </li>
        </ul>
    </main>


    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>