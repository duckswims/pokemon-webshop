<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/forms.css">
    <script src="script/form-validation.js"></script>
    <script src="script/user-creation.js"></script>

</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <main>
        <div class="container">
            <div class="box box-content box-blank">
                <h2>Welcome!</h2>
                <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/083.png">
            </div>
            <div class="box box-content">
                <h2>Register</h2>
                <form action="customer.php">
                    <input type="text" id="uName" placeholder="Username" required>
                    <input type="password" id="password" placeholder="Password" required>
                    <input type="password" id="repeatPassword" placeholder="Confirm Password" required>
                    <input type="submit" value="Register" class="btn btn-blue">
                </form><br>
                <p class="stretch">or</p>
                <p>Already a member? <a href="login.php">Login</a></p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>