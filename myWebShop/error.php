<?php
// Get the error message from the query parameter
$errorMessage = isset($_GET["error"]) ? htmlspecialchars($_GET["error"]) : "An unknown error occurred.";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <div class="container">
            <img src="https://media.printables.com/media/prints/599251/images/4771188_2e14b654-daa7-478c-8cc8-f5db25dce657_75ec0dd6-e0f7-4d1a-9c56-8a31dd407287/suprised-pikachu.png"
                alt="Pikachu" width="300px">
            <div class="error-container">
                <h1>Error</h1>
                <p><strong><?php echo $errorMessage; ?></strong></p>
                <br>
                <a href="index.php" class="button"><button>Return to Home</button></a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>