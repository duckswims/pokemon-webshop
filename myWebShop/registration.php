<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles/first-style.css">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/mystyle.css">
    <script src="script/form-validation.js"></script>

</head>
<body>
    <!-- Header -->
    <header>
        <iframe src="header.php" class="header-iframe"></iframe>
    </header>

    <main>
        <div class="form-container">
            <div class="login-box box">
                <h2>Registeration</h2>
                <form action="customer.php">
                    <label for="uName">Username</label>
                    <input type="text" id="uName" required>
                
                    <label for="password">Password</label>
                    <input type="password" id="password" required>
                
                    <label for="repeatPassword">Repeat Password</label>
                    <input type="password" id="repeatPassword" required>
                
                    <input type="submit" value="Register">
                </form><br>
            </div>
            <div class="register-box box">
                <h2>Existing Customer?</h2>
                <a href="login.php"><button type="button">Click here to login!</button></a>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer>
        <iframe src="footer.php" class="footer-iframe"></iframe>
    </footer>
</body>
</html>
