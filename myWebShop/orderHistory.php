<?php
// Start the session to access session variables
session_start();
?>
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
    <link rel="stylesheet" href="styles/buttons.css">
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <h1>Your Order History (Template)</h1>
        <fieldset>
            <legend>Recent Orders</legend>
            <table>
                <thead>
                    <tr>
                        <th>Pokemon</th>
                        <th>Date</th>
                        <th>Order No.</th>
                    </tr>
                </thead>
                <tr>
                    <td>Pikachu</td>
                    <td>dd/mm/yyyy</td>
                    <td>000123</td>
                </tr>
                <tr>
                    <td>Bulbasaur</td>
                    <td>dd/mm/yyyy</td>
                    <td>000124</td>
                </tr>
            </table>
        </fieldset>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>