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
    <link rel="stylesheet" href="styles/product_display.css">
    <script src="script/collection-list.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <main>
        <h1>Pokémon List</h1>
        <p>
            This is a Pokédex webpage designed to provide detailed information about various Pokémon, categorized by
            type and category.
        </p>
        <br>

        <div class="product-display">
            <?php
            // Load the JSON file
            $jsonString = file_get_contents('json/product.json');
            $data = json_decode($jsonString, true);

            // Check if the JSON contains the 'product' key
            if (isset($data['product'])) {
                foreach ($data['product'] as $product) {
                    echo '
                    <div class="box product-box">
                        <div class="left">
                            <img src="' . htmlspecialchars($product['img_src']) . '" width="100px">
                            <a href="product.php?pid=' . htmlspecialchars($product['pid']) . '">
                                <button>View Product</button>
                            </a>
                        </div>
                        <div class="right">
                            <h3 class="title">' . ' #' . htmlspecialchars($product['pid']) . " " . htmlspecialchars($product['name']) . '</h3>
                            <p class="desc">' . htmlspecialchars($product['desc']) . '</p>
                            <p class="price"><strong>Price: </strong>' . htmlspecialchars($product['price']) . '€</p>
                            <div class="add-div">
                                <input type="number" class="qty-input" id="quantity" value="1" min="1">
                                <button class="add-cart">Add to cart</button>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '
                <h2 style="color: red;">Error 404: Product information not found :( </h2>
                ';
            }
            ?>
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
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>