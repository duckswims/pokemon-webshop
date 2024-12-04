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
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/darkmode.css">
    <link rel="stylesheet" href="../styles/product_display.css">
    <script src="../script/collection-list.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("../header.php"); ?>
    </header>

    <main>
        <h1>Pokémon List</h1>
        <p>
            This is a Pokédex webpage designed to provide detailed information about various Pokémon, categorized by
            type and category.
        </p>
        <br>

        <div class="product-display">
            <div class="box product-box">
                <div class="left">
                    <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/001.png"
                        width="100px">
                    <a href="../product_id/0001.php">
                        <button>View Product</button>
                    </a>
                </div>
                <div class="right">
                    <h3 class="title">Bulbasaur #0001</h3>
                    <p class="desc">
                        For some time after its birth, it uses the nutrients that are packed into the seed
                    </p>

                    <div class="add-div">
                        <input type="number" class="qty-input" id="quantity" value="1" min="1">
                        <button class="add-cart">Add to cart</button>
                    </div>
                </div>
            </div>
            <div class="box product-box">
                <div class="left">
                    <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/002.png"
                        width="100px">
                    <a href="../product_id/detail.php?pid=0002">
                        <button>View Product</button>
                    </a>
                </div>
                <div class="right">
                    <h3 class="title">Ivysaur #0002</h3>
                    <p class="desc">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ab atque veniam sint iste dicta
                        placeat omnis quas eligendi amet minus unde ipsum ut excepturi minima, harum dolorem accusamus,
                        laudantium distinctio?
                    </p>

                    <div class="add-div">
                        <input type="number" class="qty-input" id="quantity" value="1" min="1">
                        <button class="add-cart">Add to cart</button>
                    </div>
                </div>
            </div>

            <div class="box product-box">
                <div class="left">
                    <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/003.png"
                        width="100px">
                    <a href="../product_id/detail.php?pid=0003">
                        <button>View Product</button>
                    </a>
                </div>
                <div class="right">
                    <h3 class="title">Venusaur #0003</h3>
                    <p class="desc">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel cum reiciendis, laborum earum
                        dolorem quod consequuntur repudiandae adipisci fugiat, architecto illo error quisquam aut magni
                        libero ipsa voluptatibus est repellendus.
                    </p>

                    <div class="add-div">
                        <input type="number" class="qty-input" id="quantity" value="1" min="1">
                        <button class="add-cart">Add to cart</button>
                    </div>
                </div>
            </div>

            <div class="box product-box">
                <div class="left">
                    <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/007.png"
                        width="100px">
                    <a href="../product_id/detail.php?pid=0007">
                        <button>View Product</button>
                    </a>
                </div>
                <div class="right">
                    <h3 class="title">Squirtle #0007</h3>
                    <p class="desc">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non minus impedit est ipsam magnam
                        quisquam saepe nesciunt veniam a architecto, animi accusantium iusto nulla vitae ipsa, hic
                        mollitia ratione repellendus!
                    </p>

                    <div class="add-div">
                        <input type="number" class="qty-input" id="quantity" value="1" min="1">
                        <button class="add-cart">Add to cart</button>
                    </div>
                </div>
            </div>

            <div class="box product-box">
                <div class="left">
                    <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/008.png"
                        width="100px">
                    <a href="../product_id/detail.php?pid=0008">
                        <button>View Product</button>
                    </a>
                </div>
                <div class="right">
                    <h3 class="title">Wartortle #0008</h3>
                    <p class="desc">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempore corporis animi dolore
                        architecto et officia unde ullam! Labore aliquam repudiandae beatae molestias hic cum, sunt
                        ipsam voluptatem maxime nisi sed?
                    </p>

                    <div class="add-div">
                        <input type="number" class="qty-input" id="quantity" value="1" min="1">
                        <button class="add-cart">Add to cart</button>
                    </div>
                </div>
            </div>

            <div class="box product-box">
                <div class="left">
                    <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/009.png"
                        width="100px">
                    <a href="../product_id/detail.php?pid=0009">
                        <button>View Product</button>
                    </a>
                </div>
                <div class="right">
                    <h3 class="title">Blastoise #0009</h3>
                    <p class="desc">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic blanditiis corrupti est molestiae
                        consectetur modi exercitationem voluptatibus, sint quae non earum placeat, in iste dolore nihil
                        aut ut, fuga expedita?
                    </p>

                    <div class="add-div">
                        <input type="number" class="qty-input" id="quantity" value="1" min="1">
                        <button class="add-cart">Add to cart</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="collection-list">
            <h2>Your Collection List</h2>
            <ul id="collection-items">
                <!-- Dynamically added collection items will appear here -->
            </ul>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("../footer.php"); ?>
    </footer>
</body>

</html>