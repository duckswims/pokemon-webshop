<?php 

if(isset($_GET["pid"])) { 
    if(empty($_GET["pid"])) { 
        echo "No value fo the parameter!"; 
    } 
} else { 
    echo "<h1>Parameter is missing!</h1>"; 
    echo '<a href="../categoryList/mainList.php">Back to category list</a>';
    exit();
}

// Read JSON file
$json = file_get_contents('../json/product.json');

//Decode JSON
$json_data = json_decode($json,true);

//Set $index according to ?pid
switch ($_GET["pid"]) {
    case "0001":
        $index = 0;
        break;
    case "0002":
        $index = 1;
        break;
    case "0003":
        $index = 2;
        break;
    case "0007":
        $index = 3;
        break;
    case "0008":
        $index = 4;
        break;
    case "0009":
        $index = 5;
        break;
}

$pid = $json_data["product"][$index]["pid"];
$name = $json_data["product"][$index]["name"];
$imgSrc = $json_data["product"][$index]["image src"];
$info = $json_data["product"][$index]["info"];
$price = $json_data["product"][$index]["price"];
$height = $json_data["product"][$index]["height"][0];
$weight = $json_data["product"][$index]["weight"];
$gender = $json_data["product"][$index]["gender"];
$abilities = $json_data["product"][$index]["abilities"];
$type = $json_data["product"][$index]["type"];
$weakness = $json_data["product"][$index]["weakness"];
$hp = $json_data["product"][$index]["hp"];
$attack = $json_data["product"][$index]["attack"];
$defense = $json_data["product"][$index]["defense"];
$spDefense = $json_data["product"][$index]["special defense"];
$spAttack = $json_data["product"][$index]["special attack"];
$speed = $json_data["product"][$index]["speed"];
$evolution = $json_data["product"][$index]["evolution"];

?>

<!DOCTYPE html>; 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$name #$pid" ?></title>
    <link rel="stylesheet" href="../styles/first-style.css">
    <link rel="stylesheet" href="../styles/forms.css">
    <link rel="stylesheet" href="../styles/mystyle.css">
    <script src="../script/collection-list.js" defer></script>
</head>
<body>
    <!-- Header -->
    <header>
        <iframe src="../header.php" class="header-iframe"></iframe>
    </header>
    
    <!-- Main Content -->
    <main>
        <!-- Wrap the main content in a flex container -->
        <div class="main-content">
            <div class="main">
                <div class="info">
                    <h1><?php echo "$name #$pid"; ?></h1>
                    <img src=<?php echo $imgSrc?> width="200px">
                    <p><?php echo $info ?></p>
                </div>
                <div class="cart">
                    <h2><?php echo "Price: €$price"?></h2>
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
                    <li>Height: 3' 03"</li>
                    <li>Weight: <?php echo $weight ?> lbs</li>
                    <li>Gender: <?php echo $gender ?></li>
                    <li><a href="../categoryList/categories/categoryList.php">Category</a>: <a href="../categoryList/categories/seed.php">Seed</a></li>
                    <li>Abilities: <?php echo $abilities ?></li>
                </ul>

                <h2><a href="../categoryList/types/typeList.php">Type</a></h2>
                <ul>
                    <?php 
                    //Loop Type elements
                    foreach ($type as $x) {
                        echo "<li>$x</li>";
                    }
                    ?>
                </ul>

                <h2>Weakness</h2>
                <ul>
                    <?php
                    //Loop Weakness elements
                    foreach ($weakness as $x) {
                        echo "<li>$x</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="stats">
                <h2>Stats</h2>
                <ul>
                    <li>HP: <?php echo $hp ?></li>
                    <li>Attack: <?php echo $attack ?></li>
                    <li>Defense: <?php echo $defense ?></li>
                    <li>Special Attack: <?php echo $spAttack ?></li>
                    <li>Special Defense: <?php echo $spDefense ?></li>
                    <li>Speed: <?php echo $speed ?></li>
                </ul>

                <h2>Evolution</h2>
                <ol>
                    <?php
                    //Loop Evolution element
                    foreach ($evolution as $x) {
                        echo "<li>$x</li>";
                    } 
                    ?>
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


