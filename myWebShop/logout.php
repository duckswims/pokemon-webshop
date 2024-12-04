<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
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
        <!-- <iframe src="header.php" class="header-iframe"></iframe> -->
        <?php include ("header.php"); ?>
    </header>

    <main>
        <h1>Logout Successful</h1>
        <hr />
        <p>
            <a href="login.php"><button>Login</button></a>
            <a href="index.php"><button>Homepage</button></a>
        </p>
    </main>

    <!-- Footer -->
    <footer>
        <iframe src="footer.php" class="footer-iframe"></iframe>
    </footer>
</body>

</html>