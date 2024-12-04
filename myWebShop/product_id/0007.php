<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Squirtle #0007</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <script src="../script/collection-list.js" defer></script>
</head>

<body>
    <!-- Header -->
    <header>
        <!-- <iframe src="header.php" class="header-iframe"></iframe> -->
        <?php include ("header.php"); ?>
    </header>

    <!-- Main Content -->
    <main>
        <div class="main-content">
            <!-- Info section -->
            <div class="main">
                <div class="info">
                    <h1>Squirtle #0007</h1>
                    <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/007.png"
                        width="200px">
                    <p>After birth, its back swells and hardens into a shell. It sprays a potent foam from its mouth.
                    </p>
                </div>
                <div class="cart">
                    <h2>Price: 5€</h2>
                    <div class="item-selection">
                        <input type="number" class="quantity-input" id="quantity" value="1" min="1">
                        <button class="add-to-collection">Add to Collection List</button>
                    </div>
                </div>
            </div>

            <!-- Description and stats in flex layout -->
            <div class="description">
                <h2>Description:</h2>
                <ul>
                    <li>Height: 1' 08"</li>
                    <li>Weight: 19.8 lbs</li>
                    <li>Gender: Male & Female</li>
                    <li><a href="../categoryList/categories/categoryList.php">Category</a>: <a
                            href="../categoryList/categories/tiny-turtle.php">Tiny Turtle</a></li>
                    <li>Abilities: Torrent</li>
                </ul>

                <h2><a href="../categoryList/types/typeList.php">Type</a></h2>
                <ul>
                    <li><a href="../categoryList/types/water.php">Water</a></li>
                </ul>

                <h2>Weakness</h2>
                <ul>
                    <li><a href="../categoryList/types/grass.php">Grass</a></li>
                    <li>Electric</li>
                </ul>
            </div>

            <div class="stats">
                <h2>Stats</h2>
                <ul>
                    <li>HP: 3/10</li>
                    <li>Attack: 3/10</li>
                    <li>Defense: 4/10</li>
                    <li>Special Attack: 3/10</li>
                    <li>Special Defense: 4/10</li>
                    <li>Speed: 3/10</li>
                </ul>

                <h2>Evolution</h2>
                <ol>
                    <li><a href="0007.php">Squirtle #0007</a> (current)</li>
                    <li><a href="0008.php">Wartortle #0008</a></li>
                    <li><a href="0009.php">Blastoise #0009</a></li>
                </ol>
            </div>
        </div>

        <iframe src="collection-list.php" class="collection-list-iframe"></iframe>

        <hr>
        <a href="../categoryList/mainList.php">Back to category list</a><br>
        <a href="../index.php">Back to main page</a><br>
    </main>

    <!-- Footer -->
    <footer>
        <iframe src="../footer.php" class="footer-iframe"></iframe>
    </footer>
</body>

</html>