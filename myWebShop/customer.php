<?php
// Start the session to access session variables
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Retrieve the username from the session
$username = $_SESSION['username'];
$jsonFile = "users/$username/info.json";

// Check if the JSON file exists for the logged-in user
if (!file_exists($jsonFile)) {
    die('User data not found.');
}

// Retrieve user data from the JSON file
$userData = json_decode(file_get_contents($jsonFile), true);

// Initialize success and error messages
$successMessage = '';
$errorMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle username change
    if (isset($_POST['changeUsername'])) {
        $newUsername = $_POST['newUsername'];

        // Check if the new username already exists
        $newPath = "users/$newUsername";
        if (file_exists($newPath)) {
            $errorMessage = 'Username already exists. Please choose another.';
        } else {
            // Rename the user's directory and update the JSON file
            rename("users/$username", $newPath);
            $userData['username'] = $newUsername;
            file_put_contents("$newPath/info.json", json_encode($userData, JSON_PRETTY_PRINT));
            $_SESSION['username'] = $newUsername; // Update session with new username
            $username = $newUsername; // Update local username variable
            $successMessage = 'Username successfully changed.';
        }
    }

    // Handle password change
    if (isset($_POST['changePassword'])) {
        $newPassword = $_POST['newPassword'];

        // Update the password in the JSON file
        $userData['password'] = $newPassword;
        file_put_contents("users/$username/info.json", json_encode($userData, JSON_PRETTY_PRINT));
        $successMessage = 'Password successfully changed.';
    }

    // Handle account deletion
    if (isset($_POST['deleteAccount'])) {
        // Delete the user's directory and all its contents
        $userDirectory = "users/$username";
        if (is_dir($userDirectory)) {
            // Delete the user folder and all its contents
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($userDirectory, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }
            rmdir($userDirectory); // Remove the now empty directory
        }

        // Redirect to the delete page
        header("Location: delete.php");
        exit;
    }
}
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
    <script src="script/form-validation.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include ("header.php"); ?>
    </header>

    <main>
        <h1>Profile</h1>
        <div class="box">
            <fieldset>
                <legend>Personal Information</legend>
                <!-- Form for changing the username -->
                <form action="" method="POST">
                    <table>
                        <tr>
                            <td><label for="newUsername">Username</label></td>
                            <td><input type="text" name="newUsername" id="newUsername"
                                    value="<?php echo htmlspecialchars($username); ?>" required></td>
                            <td><button type="submit" name="changeUsername">Change</button></td>
                        </tr>
                    </table>
                </form>

                <!-- Form for changing the password -->
                <form action="" method="POST">
                    <table>
                        <tr>
                            <td><label for="newPassword">Password</label></td>
                            <td><input type="password" name="newPassword" id="newPassword" placeholder="New Password"
                                    required></td>
                            <td><button type="submit" name="changePassword">Change</button></td>
                        </tr>
                    </table>
                </form>

                <?php if (!empty($errorMessage)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
                <?php endif; ?>

                <?php if (!empty($successMessage)): ?>
                <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
                <?php endif; ?>
            </fieldset><br>
        </div>
        <br>
        <!-- Form for deleting the account -->
        <form action="" method="POST">
            <button type="submit" name="deleteAccount" class="btn-red">Delete Account</button>
        </form>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>