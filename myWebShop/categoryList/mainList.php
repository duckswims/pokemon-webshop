<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon List</title>
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
        <iframe src="../header.php" class="header-iframe"></iframe>
    </header>

    <main>
        <h1>Pokémon List</h1>
        <p>This is a Pokédex webpage designed to provide detailed information about various Pokémon, categorized by type
            and category.</p>

        <table>
            <thead>
                <tr>
                    <td>Pokémon</td>
                    <td><a href="types/typeList.php">Type</a></td>
                    <td><a href="categories/categoryList.php">Category</a></td>
                </tr>
            </thead>
            <tbody>
                <!-- Bulbasaur #0001 -->
                <tr>
                    <td>
                        <a href="../product_id/detail.php?pid=0001">
                            <span>Bulbasaur #0001</span><br>
                            <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/001.png"
                                width="100px">
                        </a>
                    </td>
                    <td>
                        <a href="types/grass.php">Grass</a><br>
                        <a href="types/poison.php">Poison</a><br>
                    </td>
                    <td><a href="categories/seed.php">Seed</a></td>
                </tr>
                <!-- Ivysaur #0002 -->
                <tr>
                    <td>
                        <a href="../product_id/detail.php?pid=0002">
                            <span>Ivysaur #0002</span><br>
                            <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/002.png"
                                width="100px">
                        </a>
                    </td>
                    <td>
                        <a href="types/grass.php">Grass</a><br>
                        <a href="types/poison.php">Poison</a><br>
                    </td>
                    <td><a href="categories/seed.php">Seed</a></td>
                </tr>
                <!-- Venusaur #0003 -->
                <tr>
                    <td>
                        <a href="../product_id/detail.php?pid=0003">
                            <span>Venusaur #0003</span><br>
                            <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/003.png"
                                width="100px">
                        </a>
                    </td>
                    <td>
                        <a href="types/grass.php">Grass</a><br>
                        <a href="types/poison.php">Poison</a><br>
                    </td>
                    <td><a href="categories/seed.php">Seed</a></td>
                </tr>
                <!-- Squirtle #0007 -->
                <tr>
                    <td>
                        <a href="../product_id/detail.php?pid=0007">
                            <span>Squirtle #0007</span><br>
                            <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/007.png"
                                width="100px">
                        </a>
                    </td>
                    <td>
                        <a href="types/water.php">Water</a><br>
                    </td>
                    <td><a href="categories/tiny-turtle.php">Tiny Turtle</a></td>
                </tr>
                <!-- Wartortle #0008 -->
                <tr>
                    <td>
                        <a href="../product_id/detail.php?pid=0008">
                            <span>Wartortle #0008</span><br>
                            <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/008.png"
                                width="100px">
                        </a>
                    </td>
                    <td>
                        <a href="types/water.php">Water</a><br>
                    </td>
                    <td><a href="categories/turtle.php">Turtle</a></td>
                </tr>
                <!-- Blastoise #0009 -->
                <tr>
                    <td>
                        <a href="../product_id/detail.php?pid=0009">
                            <span>Blastoise #0009</span><br>
                            <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/009.png"
                                width="100px">
                        </a>
                    </td>
                    <td>
                        <a href="types/water.php">Water</a><br>
                    </td>
                    <td><a href="categories/shellfish.php">Shellfish</a></td>
                </tr>
            </tbody>
        </table>

        <hr>
        <a href="../index.php">Back to main page</a><br>
    </main>

    <!-- Footer -->
    <footer>
        <iframe src="../footer.php" class="footer-iframe"></iframe>
    </footer>
</body>

</html>