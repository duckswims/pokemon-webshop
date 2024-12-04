<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon List: Water</title>
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
        <iframe src="../../header.php" class="header-iframe"></iframe>
    </header>

    <main>
        <h1>Pokémon Types</h1>
        <p>This is a Pokédex webpage designed to provide detailed information about various Pokémon, categorized by
            type.</p>

        <h2>Sub-Type: Water</h2>

        <table>
            <thead>
                <tr>
                    <td><a href="typeList.php">Types</a></td>
                    <td>Pokémons</td>
                </tr>
            </thead>
            <tbody>
                <!-- Water -->
                <tr>
                    <td><a href="water.php">Water</a><br></td>
                    <td>
                        <ul>
                            <li><a href="../../product_id/detail.php?pid=0007">Squirtle #0007</a></li>
                            <li><a href="../../product_id/detail.php?pid=0008">Wartortle #0008</a></li>
                            <li><a href="../../product_id/detail.php?pid=0009">Blastoise #0009</a></li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr>
        <a href="../mainList.php">Back to category list</a><br>
        <a href="../../index.php">Back to main page</a><br>
    </main>

    <!-- Footer -->
    <footer>
        <iframe src="../../footer.php" class="footer-iframe"></iframe>
    </footer>
</body>

</html>