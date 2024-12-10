<?php
// Start the session to access session variables
session_start();
?>
<?php
// Get 'pid' for a single product, or 'pid1' and 'pid2' for two products
$pid = isset($_GET['pid']) ? $_GET['pid'] : null;
$pid1 = isset($_GET['pid1']) ? $_GET['pid1'] : null;
$pid2 = isset($_GET['pid2']) ? $_GET['pid2'] : null;

// Load and decode the JSON data
$jsonData = file_get_contents('json/product.json');
$products = json_decode($jsonData, true);

// Find the products by pid, pid1, and pid2
$product1 = null;
$product2 = null;

// Handle single pid query
if ($pid) {
    foreach ($products['product'] as $item) {
        if ($item['pid'] == $pid) {
            $product1 = $item; // Only one product
            break;
        }
    }
}

// Handle pid1 and pid2 queries
if ($pid1 && $pid2) {
    foreach ($products['product'] as $item) {
        if ($item['pid'] == $pid1) {
            $product1 = $item; // First product
        }
        if ($item['pid'] == $pid2) {
            $product2 = $item; // Second product
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        #<?= $product1['pid']; ?> <?= $product1['name']; ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/product_details.css">
    <script src="script/type-animations.js"></script>

</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <?php if (!$product1 && !$product2): ?>
        <div class="error-container">
            <h1>Error 404: Product not found :(</h1>
            <img src="https://media.printables.com/media/prints/599251/images/4771188_2e14b654-daa7-478c-8cc8-f5db25dce657_75ec0dd6-e0f7-4d1a-9c56-8a31dd407287/suprised-pikachu.png"
                alt="Pikachu" width="300px">
        </div>
        <?php else: ?>
        <div class="container product-container">
            <!-- Display product1 if found -->
            <?php if ($product1): ?>
            <div class="product">
                <div class="image">
                    <img src="<?= $product1['img_src']; ?>" alt="<?= $product1['name']; ?>">
                </div>
                <div class="info">
                    <h2>#<?= $product1['pid']; ?> <?= $product1['name']; ?></h2>
                    <div class='desc'>
                        <label>Description:</label>
                        <p><?= $product1['desc']; ?></p>
                    </div>
                    <div class='type'>
                        <label>Type:</label>
                        <?php foreach ($product1['type'] as $type): ?>
                        <button class="<?= $type; ?>"><?= $type; ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class='weakness'>
                        <label>Weakness:</label>
                        <?php foreach ($product1['weakness'] as $weakness): ?>
                        <button class="<?= $weakness; ?>" disabled><?= $weakness; ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class='price'>
                        <label>Price:</label>
                        <p><?= $product1['price']; ?>€</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Display product2 if found -->
            <?php if ($product2): ?>
            <div class="product">
                <div class="image">
                    <img src="<?= $product2['img_src']; ?>" alt="<?= $product2['name']; ?>">
                </div>
                <div class="info">
                    <h2>#<?= $product2['pid']; ?> <?= $product2['name']; ?></h2>
                    <div class='desc'>
                        <label>Description:</label>
                        <p><?= $product2['desc']; ?></p>
                    </div>
                    <div class='type'>
                        <label>Type:</label>
                        <?php foreach ($product2['type'] as $type): ?>
                        <button class="<?= htmlspecialchars($type); ?>"><?= $type; ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class='weakness'>
                        <label>Weakness:</label>
                        <?php foreach ($product2['weakness'] as $weakness): ?>
                        <button class="<?= htmlspecialchars($weakness); ?>" disabled><?= $weakness; ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class='price'>
                        <label>Price:</label>
                        <p><?= $product2['price']; ?>€</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>