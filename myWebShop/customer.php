<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <script src="script/form-validation.js"></script>

</head>

<body>
    <!-- Header -->
    <header>
        <iframe src="header.php" class="header-iframe"></iframe>
    </header>

    <main>
        <h1>Profile</h1>
        <div class="profile-box">
            <fieldset>
                <legend>Personal Information</legend>
                <table>
                    <tr>
                        <td><label for="uName">Username</label></td>
                        <td><input type="text" name="username" id="uName" placeholder="wumpus123" required></td>
                        <td><input type="submit" value="Change"></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password</label></td>
                        <td><input type="password" name="password" id="password" placeholder="abc123" required></td>
                        <td><input type="submit" value="Change"></td>
                    </tr>
                    <tr>
                        <td>First Name:</td>
                        <td>Ash</td>
                    </tr>
                    <tr>
                        <td>Last Name:</td>
                        <td>Ketchum</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>Esplanade 10, 85049 Ingolstadt</td>
                    </tr>
                </table>
            </fieldset><br>
        </div>
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
        </fieldset><br>
        <button type="button">Unregister</button>
        <a href="logout.php"><button type="button">Logout</button></a>
    </main>

    <!-- Footer -->
    <footer>
        <iframe src="footer.php" class="footer-iframe"></iframe>
    </footer>
</body>

</html>