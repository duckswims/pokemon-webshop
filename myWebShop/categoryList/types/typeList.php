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
    <link rel="stylesheet" href="../../styles/styles.css">
    <link rel="stylesheet" href="../../styles/darkmode.css">
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("../../header.php"); ?>
    </header>

    <main>
        <h1>Pokémon Types</h1>
        <p>This is a Pokédex webpage designed to provide detailed information about various Pokémon, categorized by
            type.</p>

        <table>
            <thead>
                <tr>
                    <td><a href="typeList.php">Types</a></td>
                    <td>Pokémons</td>
                </tr>
            </thead>
            <tbody>
                <!-- Grass -->
                <tr>
                    <td><a href="grass.php">Grass</a><br></td>
                    <td>
                        <ul>
                            <li><a href="../../product_id/detail.php?pid=0001">Bulbasaur #0001</a></li>
                            <li><a href="../../product_id/detail.php?pid=0002">Ivysaur #0002</a></li>
                            <li><a href="../../product_id/detail.php?pid=0003">Venusaur #0003</a></li>
                        </ul>
                    </td>
                </tr>
                <!-- Poison -->
                <tr>
                    <td><a href="poison.php">Poison</a><br></td>
                    <td>
                        <ul>
                            <li><a href="../../product_id/detail.php?pid=0001">Bulbasaur #0001</a></li>
                            <li><a href="../../product_id/detail.php?pid=0002">Ivysaur #0002</a></li>
                            <li><a href="../../product_id/detail.php?pid=0003">Venusaur #0003</a></li>
                        </ul>
                    </td>
                </tr>
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
    <?php include ("../../footer.php"); ?>
    </footer>
</body>

</html>